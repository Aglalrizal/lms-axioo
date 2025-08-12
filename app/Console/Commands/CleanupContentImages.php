<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog;
use App\Models\Course;
use App\Models\CourseContent;
use App\Traits\HandlesBase64Images;

class CleanupContentImages extends Command
{
    use HandlesBase64Images;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:cleanup-images 
                            {--folder= : Specific folder to clean (blog_images, course_images, blog_thumbnails, etc)}
                            {--dry-run : Preview files that will be deleted without actually deleting them}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up unused images from content (blogs, courses, etc)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folder = $this->option('folder');
        $isDryRun = $this->option('dry-run');

        if ($folder) {
            $this->cleanupFolder($folder, $isDryRun);
        } else {
            // Clean all known folders - collect all orphans first
            $allOrphans = [];
            $folders = ['blog_images', 'blog_thumbnails', 'course_images', 'course_thumbnails', 'user_profile_photos'];

            foreach ($folders as $folderName) {
                $orphans = $this->scanFolder($folderName);
                if (!empty($orphans)) {
                    $allOrphans[$folderName] = $orphans;
                }
            }

            if (empty($allOrphans)) {
                $this->info('✅ No orphan images found in any folder.');
                if ($isDryRun) {
                    $this->info('Dry run completed. No files were actually deleted.');
                }
            } else {
                $this->showOrphanSummary($allOrphans);

                if ($isDryRun) {
                    $this->info('Dry run completed. No files were actually deleted.');
                } else {
                    $totalOrphans = array_sum(array_map('count', $allOrphans));
                    if ($this->confirm("Do you want to delete these {$totalOrphans} orphan images?")) {
                        $this->performBulkDeletion($allOrphans);
                        $this->info('Image cleanup completed successfully!');
                    } else {
                        $this->info('Operation cancelled. No files were deleted.');
                    }
                }
            }
        }

        // Single folder cleanup still uses the old method for individual confirmation
        if ($folder && !$isDryRun) {
            $this->info('Image cleanup completed successfully!');
        }
    }

    /**
     * Clean up a specific folder
     */
    private function cleanupFolder(string $folder, bool $isDryRun): void
    {
        $this->info("Cleaning up folder: {$folder}");

        $allContent = $this->getAllContentForFolder($folder);

        if (empty($allContent)) {
            $this->warn("No content found for folder: {$folder}");
            return;
        }

        if ($isDryRun) {
            $deletedFiles = $this->previewCleanup($allContent, $folder);

            if (empty($deletedFiles)) {
                $this->info("✅ No orphan images found in {$folder}");
            } else {
                $this->warn("🗑️  Found " . count($deletedFiles) . " orphan images in {$folder}:");
                foreach ($deletedFiles as $file) {
                    $this->line("   - {$file}");
                }
            }
        } else {
            $filesToDelete = $this->previewCleanup($allContent, $folder);

            if (empty($filesToDelete)) {
                $this->info("✅ No orphan images found in {$folder}");
            } else {
                $this->info("🗑️  Found " . count($filesToDelete) . " orphan images in {$folder}:");
                foreach ($filesToDelete as $file) {
                    $this->line("   - {$file}");
                }

                // Ask for confirmation before deleting
                if ($this->confirm("Do you want to delete these " . count($filesToDelete) . " orphan images?")) {
                    $actuallyDeleted = $this->performDeletion($filesToDelete);
                    $this->info("🗑️  Deleted " . count($actuallyDeleted) . " orphan images from {$folder}:");
                    foreach ($actuallyDeleted as $file) {
                        $this->line("   ✓ {$file}");
                    }
                } else {
                    $this->info("Operation cancelled. No files were deleted.");
                    return;
                }
            }
        }
    }

    /**
     * Get all content for a specific folder
     */
    private function getAllContentForFolder(string $folder): array
    {
        $allContent = [];

        switch ($folder) {
            case 'blog_images':
                $blogs = Blog::select('content')->get();
                foreach ($blogs as $blog) {
                    if ($blog->content) {
                        $allContent[] = $blog->content;
                    }
                }
                break;

            case 'course_images':
                $courseContents = CourseContent::select('content')->get();
                $courses = Course::select('description', 'extra_description')->get();

                foreach ($courseContents as $content) {
                    if ($content->content) {
                        $allContent[] = $content->content;
                    }
                }

                foreach ($courses as $course) {
                    if ($course->description) {
                        $allContent[] = $course->description;
                    }
                    if ($course->extra_description) {
                        $allContent[] = $course->extra_description;
                    }
                }
                break;

            case 'blog_thumbnails':
                // For thumbnails, we check photo_path field instead of content
                $blogs = Blog::select('photo_path')->whereNotNull('photo_path')->get();
                foreach ($blogs as $blog) {
                    // Create fake content with img tag for thumbnail processing
                    if ($blog->photo_path) {
                        $thumbnailUrl = asset('storage/' . $blog->photo_path);
                        $fakeContent = '<img src="' . $thumbnailUrl . '" />';
                        $allContent[] = $fakeContent;
                    }
                }
                break;

            case 'course_thumbnails':
                $courses = Course::select('thumbnail')->whereNotNull('thumbnail')->get();

                foreach ($courses as $course) {
                    // Create fake content with img tag for thumbnail processing
                    if ($course->thumbnail) {
                        $thumbnailUrl = asset('storage/' . $course->thumbnail);
                        $fakeContent = '<img src="' . $thumbnailUrl . '" />';
                        $allContent[] = $fakeContent;
                    }
                }
                break;

            case 'user_profile_photos':
                // For user profile photos, check profile_picture_path field
                $users = \App\Models\User::select('profile_picture_path')->whereNotNull('profile_picture_path')->get();

                foreach ($users as $user) {
                    if ($user->profile_picture_path) {
                        $profileUrl = asset('storage/' . $user->profile_picture_path);
                        $fakeContent = '<img src="' . $profileUrl . '" />';
                        $allContent[] = $fakeContent;
                    }
                }
                break;

            default:
                $this->warn("Unknown folder: {$folder}. Supported folders: blog_images, course_images, blog_thumbnails, course_thumbnails, user_profile_photos");
                break;
        }

        return $allContent;
    }

    /**
     * Preview cleanup without actually deleting files
     */
    private function previewCleanup(array $allContent, string $folder): array
    {
        // Get all files in folder
        $allFiles = Storage::disk('public')->files($folder);

        // Get all images used in content
        $usedImages = [];
        foreach ($allContent as $content) {
            $contentImages = $this->getContentImages($content, $folder);
            $usedImages = array_merge($usedImages, $contentImages);
        }

        $usedImages = array_unique($usedImages);

        // Find orphan files
        return array_diff($allFiles, $usedImages);
    }

    /**
     * Perform actual deletion of files
     */
    private function performDeletion(array $filesToDelete): array
    {
        $deletedFiles = [];

        foreach ($filesToDelete as $file) {
            try {
                if (Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                    $deletedFiles[] = $file;
                }
            } catch (\Exception $e) {
                $this->error("Failed to delete: {$file} - " . $e->getMessage());
            }
        }

        return $deletedFiles;
    }

    /**
     * Scan folder for orphan images without deleting
     */
    private function scanFolder(string $folder): array
    {
        $this->info("Scanning folder: {$folder}");

        $allContent = $this->getAllContentForFolder($folder);

        // Check if folder exists
        if (!Storage::disk('public')->exists($folder)) {
            $this->line("Folder {$folder} does not exist");
            return [];
        }

        // Get all files in folder
        $allFiles = Storage::disk('public')->files($folder);

        if (empty($allFiles)) {
            $this->line("No files found in folder: {$folder}");
            return [];
        }

        if (empty($allContent)) {
            $this->line("No content found for folder: {$folder} - all files are orphans");
            return $allFiles; // All files are orphans if no content references them
        }

        return $this->previewCleanup($allContent, $folder);
    }

    /**
     * Show summary of all orphan images
     */
    private function showOrphanSummary(array $allOrphans): void
    {
        $totalOrphans = 0;

        foreach ($allOrphans as $folder => $orphans) {
            $count = count($orphans);
            $totalOrphans += $count;

            $this->warn("🗑️  Found {$count} orphan images in {$folder}:");
            foreach ($orphans as $file) {
                $this->line("   - {$file}");
            }
        }

        $this->info("\n📊 Total: {$totalOrphans} orphan images found across all folders.");
    }

    /**
     * Perform bulk deletion across multiple folders
     */
    private function performBulkDeletion(array $allOrphans): void
    {
        $totalDeleted = 0;

        foreach ($allOrphans as $folder => $orphans) {
            $this->info("\n🗑️  Deleting orphan images from {$folder}:");
            $deleted = $this->performDeletion($orphans);
            $totalDeleted += count($deleted);

            foreach ($deleted as $file) {
                $this->line("   ✓ {$file}");
            }
        }

        $this->info("\n🎉 Successfully deleted {$totalDeleted} orphan images!");
    }
}
