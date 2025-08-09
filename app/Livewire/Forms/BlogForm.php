<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Blog;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BlogForm extends Form
{
    public $blog;
    public $photo;
    public $title;
    public $slug;
    public $blog_category_id;
    public $content;
    public $excerpt;

    public $status;

    public $old_photo_path = '';
    public $photo_path = '';

    public $excerptMaxLength = 120; // Tambah property ini

    public function setBlog($blog)
    {
        $this->title = $blog->title;
        $this->slug = $blog->slug;
        $this->blog_category_id = $blog->blog_category_id;
        $this->content = $blog->content;
        $this->old_photo_path = $blog->photo_path;
        $this->photo_path = $blog->photo_path;

        $this->blog = $blog;
    }

    protected function rules()
    {
        $rules = [
            'title' => 'required|max:60|string',
            'slug' => [
                'required',
                'string',
                'max:72',
                'lowercase',
                Rule::unique('blogs')->ignore($this->blog)
            ],
            'blog_category_id' => [
                'required',
                Rule::in(BlogCategory::pluck('id')->toArray())
            ],
            'content' => 'required',
        ];

        $this->status === 'published' ?
            $rules['photo'] = 'required|image|max:2048' :
            $rules['photo'] = 'image|max:2048|nullable';

        return $rules;
    }

    protected function messages()
    {
        return [
            'photo.required' => 'Thumbnail dibutuhkan ketika ingin publish.',
            'photo.image' => 'Thumbnail harus berupa gambar.',
            'photo.max' => 'Thumbnail harus lebih kecil dari :values.',
            'title.required' => 'Judul tidak boleh kosong.',
            'title.max' => 'Judul terlalu panjang.',
            'slug.required' => 'Slug tidak boleh kosong.',
            'slug.max' => 'Slug terlalu panjang.',
            'slug.unique' => 'Slug sudah digunakan.',
            'slug.lowercase' => 'Slug harus menggunakan huruf kecil.',
            'content.required' => 'Konten tidak boleh kosong.',
        ];
    }

    public function publish()
    {
        if (!$this->photo) {
            flash()->error('Thumbnail dibutuhkan ketika ingin publish.');
            return;
        }

        if (!Storage::disk('public')->exists($this->photo_path)) {
            flash()->error('Thumbnail Belum disimpan. Simpan blog terlebih dahulu.');
            return;
        }

        $this->validate();

        $this->blog->update(['status' => 'published', 'published_at' => now()]);

        flash()->success('Blog berhasil dipublikasikan.');
    }

    public function store()
    {
        // Clean content dari base64 images sebelum validasi
        $this->content = $this->processBase64Images($this->content);

        $this->cleanExcerpt();

        $validatedData = $this->validate();

        $validatedData['published_at'] = now();

        if ($this->photo) {
            $this->photo_path = $this->photo->storePublicly('blog_thumbnails', ['disk' => 'public']);

            $validatedData['photo_path'] = $this->photo_path;
        }

        $validatedData['user_id'] = Auth::id();
        $validatedData['status'] = $this->status;
        $validatedData['excerpt'] = $this->excerpt;

        Blog::create($validatedData);
    }

    public function update()
    {
        // Dapatkan konten lama sebelum diubah
        $oldContent = $this->blog->content;

        // Clean content dari base64 images sebelum validasi
        $this->content = $this->processBase64Images($this->content);

        $this->cleanExcerpt();

        $this->validate();

        // Hapus gambar yang tidak lagi digunakan di konten
        $this->removeUnusedImages($oldContent, $this->content);

        // jika ada foto baru
        if ($this->photo) {
            // hapus foto lama, jika ada
            if (Storage::disk('public')->exists($this->old_photo_path)) {
                Storage::disk('public')->delete($this->old_photo_path);
            }

            // simpan foto baru
            $this->photo_path = $this->photo->storePublicly('blog_thumbnails', ['disk' => 'public']);
        }

        $this->blog->update(
            $this->only([
                'photo_path',
                'title',
                'slug',
                'blog_category_id',
                'content',
                'excerpt'
            ])
        );
    }


    public function cleanExcerpt()
    {
        if (empty($this->excerpt)) {
            $this->excerpt = '';
            return;
        }

        // Trim dan bersihkan whitespace
        $cleaned = preg_replace('/\s+/', ' ', trim($this->excerpt));

        // Potong sesuai max length
        $this->excerpt = strlen($cleaned) > $this->excerptMaxLength
            ? substr($cleaned, 0, $this->excerptMaxLength) . '...'
            : $cleaned;
    }

    /** 
     * Process base64 images in content and convert them to stored images
     */
    private function processBase64Images($content)
    {
        // Pattern untuk mencari base64 images
        $pattern = '/<img[^>]+src="data:image\/([^;]+);base64,([^"]+)"[^>]*>/i';

        return preg_replace_callback($pattern, function ($matches) {
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
                $path = 'blog_images/' . $filename;

                // Store image
                Storage::disk('public')->put($path, $imageData);

                // Replace dengan URL yang benar
                $newSrc = asset('storage/' . $path);
                $imgTag = str_replace($matches[0], preg_replace('/src="[^"]*"/', 'src="' . $newSrc . '"', $matches[0]), $matches[0]);

                return $imgTag;
            } catch (\Exception $e) {
                // Jika gagal, ganti dengan placeholder
                return '[Image could not be processed]';
            }
        }, $content);
    }

    /** 
     * Remove unused images from storage when they are deleted from content
     */
    private function removeUnusedImages($oldContent, $newContent)
    {
        // Dapatkan semua URL gambar dari konten lama
        $oldImages = $this->extractImageUrls($oldContent);

        // Dapatkan semua URL gambar dari konten baru
        $newImages = $this->extractImageUrls($newContent);

        // Cari gambar yang tidak lagi digunakan
        $removedImages = array_diff($oldImages, $newImages);

        // Hapus gambar yang tidak lagi digunakan dari storage
        foreach ($removedImages as $imageUrl) {
            $this->deleteImageFromStorage($imageUrl);
        }
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
                // Hanya ambil gambar yang ada di folder blog_images
                if (strpos($url, '/storage/blog_images/') !== false) {
                    $imageUrls[] = $url;
                }
            }
        }

        return array_unique($imageUrls);
    }

    /** 
     * Delete image file from storage based on URL
     */
    private function deleteImageFromStorage($imageUrl)
    {
        try {
            // Extract path dari URL
            // Contoh: http://localhost/storage/blog_images/filename.jpg -> blog_images/filename.jpg
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
}
