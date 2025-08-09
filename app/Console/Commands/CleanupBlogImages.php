<?php

namespace App\Console\Commands;

use App\Models\Blog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupBlogImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:cleanup-images {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup unused blog images and thumbnails from storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        $this->info('Starting blog images and thumbnails cleanup...');

        // Dapatkan semua file gambar di folder blog_images dan blog_thumbnails
        $blogImages = Storage::disk('public')->files('blog_images');
        $blogThumbnails = Storage::disk('public')->files('blog_thumbnails');
        $allImages = array_merge($blogImages, $blogThumbnails);

        if (empty($allImages)) {
            $this->info('No images found in blog_images or blog_thumbnails folders.');
            return;
        }

        // Dapatkan semua gambar yang sedang digunakan (content images + thumbnails)
        $usedImages = $this->getUsedImages();

        // Cari gambar yang tidak terpakai
        $unusedImages = [];
        foreach ($allImages as $imagePath) {
            // Bandingkan dengan cara yang lebih robust - ekstrak filename dari used images
            $isUsed = false;
            $fileName = basename($imagePath);

            foreach ($usedImages as $usedImage) {
                if (strpos($usedImage, $fileName) !== false) {
                    $isUsed = true;
                    break;
                }
            }

            if (!$isUsed) {
                $unusedImages[] = $imagePath;
            }
        }

        if (empty($unusedImages)) {
            $this->info('No unused images found.');
            return;
        }

        $this->info('Found ' . count($unusedImages) . ' unused images:');

        foreach ($unusedImages as $imagePath) {
            $this->line('- ' . $imagePath);
        }

        if ($isDryRun) {
            $this->warn('DRY RUN: No files were actually deleted. Use without --dry-run to delete these files.');
            return;
        }

        if (!$this->confirm('Do you want to delete these unused images?')) {
            $this->info('Operation cancelled.');
            return;
        }

        // Hapus gambar yang tidak terpakai
        $deletedCount = 0;
        foreach ($unusedImages as $imagePath) {
            if (Storage::disk('public')->delete($imagePath)) {
                $deletedCount++;
                $this->line('Deleted: ' . $imagePath);
            } else {
                $this->error('Failed to delete: ' . $imagePath);
            }
        }

        $this->info("Cleanup completed. Deleted {$deletedCount} unused images.");
    }

    /**
     * Get all image URLs that are currently used in blogs (content images and thumbnails)
     */
    private function getUsedImages()
    {
        $usedImages = [];

        // Cek semua blog yang ada
        Blog::chunk(100, function ($blogs) use (&$usedImages) {
            foreach ($blogs as $blog) {
                // Ambil gambar dari konten
                if ($blog->content) {
                    $contentImages = $this->extractImageUrls($blog->content);
                    $usedImages = array_merge($usedImages, $contentImages);
                }

                // Tambahkan thumbnail/photo_path jika ada
                if ($blog->photo_path) {
                    $thumbnailUrl = asset('storage/' . $blog->photo_path);
                    $usedImages[] = $thumbnailUrl;
                }
            }
        });

        return array_unique($usedImages);
    }

    /**
     * Extract image URLs from content
     */
    private function extractImageUrls($content)
    {
        $pattern = '/<img[^>]+src="([^"]+)"[^>]*>/i';
        preg_match_all($pattern, $content, $matches);

        $imageUrls = [];
        if (isset($matches[1])) {
            foreach ($matches[1] as $url) {
                // Ambil gambar yang ada di folder blog_images atau blog_thumbnails
                if (
                    strpos($url, '/storage/blog_images/') !== false ||
                    strpos($url, '/storage/blog_thumbnails/') !== false
                ) {
                    $imageUrls[] = $url;
                }
            }
        }

        return $imageUrls;
    }
}
