<?php

namespace App\Livewire\Forms;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Traits\HandlesBase64Images;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Form;

class BlogForm extends Form
{
    use HandlesBase64Images;

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

    public $excerptMaxLength = 256; // Tambah property ini

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
            'title' => 'required|max:80|string',
            'slug' => [
                'required',
                'string',
                'max:80',
                'lowercase',
                Rule::unique('blogs')->ignore($this->blog),
            ],
            'blog_category_id' => [
                'required',
                Rule::in(BlogCategory::pluck('id')->toArray()),
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
        if (! $this->old_photo_path && ! $this->photo) {
            flash()->error('Thumbnail dibutuhkan ketika ingin publish.');

            return;
        }

        if (! Storage::disk('public')->exists($this->photo_path)) {
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
        $this->content = $this->processBase64Images($this->content, 'blog_images');

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
        $this->content = $this->processBase64Images($this->content, 'blog_images');

        $this->cleanExcerpt();

        $this->validate();

        // Hapus gambar yang tidak lagi digunakan di konten
        $this->removeUnusedImages($oldContent, $this->content, 'blog_images');

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
                'excerpt',
            ])
        );
    }

    public function cleanExcerpt()
    {

        $this->excerpt = $this->stripHtmlAndClean($this->content);

        // Potong sesuai max length
        $this->excerpt = strlen($this->excerpt) > $this->excerptMaxLength
            ? substr($this->excerpt, 0, $this->excerptMaxLength).'...'
            : $this->excerpt;
    }

    /**
     * Strip HTML tags and clean text
     */
    private function stripHtmlAndClean($htmlContent)
    {
        // Strip HTML tags
        $text = strip_tags($htmlContent);

        // Decode HTML entities
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

        // Remove extra whitespace, newlines, dan normalize spaces
        $text = preg_replace('/\s+/', ' ', $text);

        // Trim whitespace
        $text = trim($text);

        // Potong sesuai max length
        if (strlen($text) > $this->excerptMaxLength) {
            // Potong di kata terdekat untuk menghindari kata terpotong
            $text = substr($text, 0, $this->excerptMaxLength);
            $lastSpace = strrpos($text, ' ');

            if ($lastSpace !== false && $lastSpace > ($this->excerptMaxLength * 0.8)) {
                $text = substr($text, 0, $lastSpace);
            }

            $text .= '...';
        }

        return $text;
    }
}
