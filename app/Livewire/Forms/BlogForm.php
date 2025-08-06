<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Blog;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogForm extends Form
{
    public $blog;
    public $photo;
    public $title;
    public $slug;
    public $blog_category_id;
    public $content;

    public $status;

    public $old_photo_path = '';
    public $photo_path = '';

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
        $validatedData = $this->validate();

        $validatedData['published_at'] = now();

        if ($this->photo) {
            $this->photo_path = $this->photo->storePublicly('blog_photos', ['disk' => 'public']);

            $validatedData['photo_path'] = $this->photo_path;
        }

        $validatedData['user_id'] = Auth::id();
        $validatedData['status'] = $this->status;
        $validatedData['excerpt'] = Str::limit($this->content, 120);

        Blog::create($validatedData);
    }

    public function update()
    {
        $this->validate();

        if ($this->photo) {
            if (Storage::disk('public')->exists($this->old_photo_path)) {
                Storage::disk('public')->delete($this->old_photo_path);
            }

            $this->photo_path = $this->photo->storePublicly('blog_photos', ['disk' => 'public']);
        }

        $this->blog->update(
            $this->only([
                'photo_path',
                'title',
                'slug',
                'blog_category_id',
                'content'
            ])
        );
    }
}
