<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    /** @use HasFactory<\Database\Factories\BlogFactory> */
    use HasFactory, SoftDeletes, LogsActivity;

    function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('blog');
    }
    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';
        
        return match ($eventName) {
            'created' => "[{$actor}] membuat blog \"{$this->title}\"",
            'updated' => "[{$actor}] memperbarui blog \"{$this->title}\"",
            'deleted' => "[{$actor}] menghapus blog \"{$this->title}\"",
            default => ucfirst($eventName) . " blog \"{$this->title}\"",
        };
    }

    protected $casts = [
        'published_at' => 'datetime'
    ];

    protected $fillable = [
        'user_id',
        'blog_category_id',
        'title',
        'slug',
        'content',
        'status',
        'excerpt',
        'photo_path',
        'published_at'
    ];

    protected static function boot()
    {
        parent::boot();

        // Event listener untuk menghapus gambar ketika blog dihapus
        static::deleting(function ($blog) {
            $blog->deleteAllBlogImages();
        });
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Made With AI
     * Delete all images associated with this blog
     */
    public function deleteAllBlogImages()
    {
        try {
            // Hapus thumbnail jika ada
            if ($this->photo_path && Storage::disk('public')->exists($this->photo_path)) {
                Storage::disk('public')->delete($this->photo_path);
            }

            // Hapus semua gambar di konten
            $this->deleteContentImages();
        } catch (\Exception $e) {
            Log::warning("Failed to delete blog images for blog ID {$this->id}: " . $e->getMessage());
        }
    }

    /** Made With AI
     * Delete all images from blog content
     */
    private function deleteContentImages()
    {
        if (!$this->content) {
            return;
        }

        // Extract semua URL gambar dari konten
        $pattern = '/<img[^>]+src="([^"]+)"[^>]*>/i';
        preg_match_all($pattern, $this->content, $matches);

        if (isset($matches[1])) {
            foreach ($matches[1] as $imageUrl) {
                // Hanya hapus gambar yang ada di folder blog_images
                if (strpos($imageUrl, '/storage/blog_images/') !== false) {
                    $this->deleteImageFromUrl($imageUrl);
                }
            }
        }
    }

    /** Made With AI
     * Delete image file from storage based on URL
     */
    private function deleteImageFromUrl($imageUrl)
    {
        try {
            // Extract path dari URL
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
            Log::warning("Failed to delete image: " . $imageUrl . " - " . $e->getMessage());
        }
    }
}
