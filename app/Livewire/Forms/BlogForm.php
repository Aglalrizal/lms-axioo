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
    public $photo_path = '';

    public function setBlog($blog)
    {
        $this->title = $blog->title;
        $this->slug = $blog->slug;
        $this->blog_category_id = $blog->blog_category_id;
        $this->content = $blog->content;
        $this->photo_path = $blog->photo_path;

        $this->blog = $blog;
    }

    protected function rules()
    {
        return [
            // 'photo' => 'required|mimes:jpeg,png,jpg,svg|max:2048',
            'photo' => 'required|image|max:4096',
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
            'content' => 'required'
        ];
    }

    protected function messages()
    {
        return [
            'photo.required' => 'The :attribute are missing.',
            'photo.image' => 'The :attribute must be an image.',
            'photo.max' => 'The :attribute must be below :values.',
            'title.required' => 'The :attribute are missing.',
            'title.max' => 'The :attribute is too large.',
            'slug.required' => 'The :attribute are missing.',
            'slug.max' => 'The :attribute is too large.',
            'slug.unique' => 'The :attribute has already been taken.',
            'slug.lowercase' => 'The :attribute must be lowercase.',
            'content.required' => 'The :attribute are missing.',
        ];
    }

    public function store()
    {
        $validatedData = $this->validate();

        if ($this->photo) {
            $this->photo_path = $this->photo->storePublicly('blog_photos', ['disk' => 'public']);
        }

        $validatedData['photo_path'] = $this->photo_path;
        $validatedData['user_id'] = Auth::id();
        $validatedData['status'] = $this->status;
        $validatedData['excerpt'] = Str::limit($this->content, 120);

        Blog::create($validatedData);
        // Blog::create($this->only($validatedData));   
    }

    public function update()
    {
        $this->validate();

        if ($this->photo) {
            Storage::disk('public')->delete($this->photo_path);
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
