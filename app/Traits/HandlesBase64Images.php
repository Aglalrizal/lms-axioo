<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

trait HandlesBase64Images
{
    /**
     * Process base64 images in content and convert them to stored images
     *
     * @param string $content Content with potential base64 images
     * @param string $folder Storage folder for images (default: 'content_images')
     * @return string Content with base64 images replaced with file URLs
     */
    public function processBase64Images(string $content, string $folder = 'content_images'): string
    {
        // Pattern untuk mencari base64 images
        $pattern = '/<img[^>]+src="data:image\/([^;]+);base64,([^"]+)"[^>]*>/i';

        return preg_replace_callback($pattern, function ($matches) use ($folder) {
            try {
                $imageType = $matches[1];
                $base64Data = $matches[2];

                // Decode base64
                $imageData = base64_decode($base64Data);

                if ($imageData === false) {
                    return '[Invalid image data]';
                }

                // Generate filename
                $filename = Str::uuid() . '.' . $imageType;
                $path = $folder . '/' . $filename;

                // Store image
                Storage::disk('public')->put($path, $imageData);

                // Replace dengan URL yang benar
                $newSrc = asset('storage/' . $path);
                $imgTag = str_replace($matches[0], preg_replace('/src="[^"]*"/', 'src="' . $newSrc . '"', $matches[0]), $matches[0]);

                return $imgTag;
            } catch (\Exception $e) {
                // Log error untuk debugging
                Log::warning("Failed to process base64 image: " . $e->getMessage());

                // Jika gagal, ganti dengan placeholder
                return '[Image could not be processed]';
            }
        }, $content);
    }

    /**
     * Remove unused images from storage when they are deleted from content
     *
     * @param string|null $oldContent Previous content
     * @param string $newContent New content
     * @param string $folder Storage folder to check (default: 'content_images')
     * @return void
     */
    public function removeUnusedImages(?string $oldContent, string $newContent, string $folder): void
    {
        if (!$oldContent) return;

        // Dapatkan semua URL gambar dari konten lama
        $oldImages = $this->extractImageUrls($oldContent, $folder);

        // Dapatkan semua URL gambar dari konten baru
        $newImages = $this->extractImageUrls($newContent, $folder);

        // Cari gambar yang tidak lagi digunakan
        $removedImages = array_diff($oldImages, $newImages);

        // Hapus gambar yang tidak lagi digunakan dari storage
        foreach ($removedImages as $imageUrl) {
            $this->deleteImageFromStorage($imageUrl);
        }
    }

    /**
     * Extract image URLs from content for specific folder
     *
     * @param string $content Content to extract images from
     * @param string $folder Storage folder to filter by
     * @return array Array of image URLs
     */
    protected function extractImageUrls(string $content, string $folder = 'content_images'): array
    {
        $pattern = '/<img[^>]+src="([^"]+)"[^>]*>/i';
        preg_match_all($pattern, $content, $matches);

        $imageUrls = [];
        if (isset($matches[1])) {
            foreach ($matches[1] as $url) {
                // Hanya ambil gambar yang ada di folder yang ditentukan
                if (strpos($url, '/storage/' . $folder . '/') !== false) {
                    $imageUrls[] = $url;
                }
            }
        }

        return array_unique($imageUrls);
    }

    /**
     * Delete image file from storage based on URL
     *
     * @param string $imageUrl Image URL to delete
     * @return void
     */
    protected function deleteImageFromStorage(string $imageUrl): void
    {
        try {
            // Extract path dari URL
            // Contoh: http://localhost/storage/content_images/filename.jpg -> content_images/filename.jpg
            if (strpos($imageUrl, '/storage/') !== false) {
                // Ambil bagian setelah '/storage/'
                $parts = explode('/storage/', $imageUrl);
                if (count($parts) > 1) {
                    $path = $parts[1];

                    // Hapus file jika ada
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        } catch (\Exception $e) {
            // Log error tapi jangan biarkan gagal
            Log::warning("Failed to delete image: " . $imageUrl . " - " . $e->getMessage());
        }
    }

    /**
     * Get all images from content for cleanup purposes
     *
     * @param string $content Content to extract images from
     * @param string $folder Storage folder to filter by
     * @return array Array of file paths (relative to storage/app/public)
     */
    public function getContentImages(string $content, string $folder = 'content_images'): array
    {
        $imageUrls = $this->extractImageUrls($content, $folder);
        $filePaths = [];

        foreach ($imageUrls as $url) {
            if (strpos($url, '/storage/') !== false) {
                $parts = explode('/storage/', $url);
                if (count($parts) > 1) {
                    $filePaths[] = $parts[1];
                }
            }
        }

        return $filePaths;
    }

    /**
     * Clean up all images in a folder that are not referenced in any content
     *
     * @param array $allContentWithImages Array of content strings to check against
     * @param string $folder Storage folder to clean
     * @return array Array of deleted file paths
     */
    public function cleanupOrphanImages(array $allContentWithImages, string $folder = 'content_images'): array
    {
        // Dapatkan semua file gambar di folder
        $allFiles = Storage::disk('public')->files($folder);

        // Dapatkan semua gambar yang digunakan dalam konten
        $usedImages = [];
        foreach ($allContentWithImages as $content) {
            $contentImages = $this->getContentImages($content, $folder);
            $usedImages = array_merge($usedImages, $contentImages);
        }

        $usedImages = array_unique($usedImages);

        // Cari file yang tidak digunakan
        $orphanFiles = array_diff($allFiles, $usedImages);

        // Hapus file yang tidak digunakan
        $deletedFiles = [];
        foreach ($orphanFiles as $file) {
            try {
                if (Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                    $deletedFiles[] = $file;
                }
            } catch (\Exception $e) {
                Log::warning("Failed to delete orphan image: " . $file . " - " . $e->getMessage());
            }
        }

        return $deletedFiles;
    }
}
