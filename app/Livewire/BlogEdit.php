<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use App\Models\BlogCategory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class BlogEdit extends Component
{
    public $blog;
    public $title;
    public $slug;
    public $blog_category_id;
    public $content;

    protected function rules()
    {
        return [
            'title' => 'required|max:60|min:5|string',
            'slug' => [
                'required',
                'string',
                'max:72',
                'min:5',
                Rule::unique('blogs')
            ],
            'blog_category_id' => [
                'required',
                Rule::in(BlogCategory::pluck('id')->toArray())
            ],
            'content' => 'required|min:32|max:2000'
        ];
    }

    public function mount($blog)
    {
        $this->title = $blog->title;
        $this->slug = $blog->slug;
        $this->blog_category_id = $blog->blog_category_id;
        $this->content = $blog->content;

        $this->blog = $blog->load('author');
    }

    public function submit()
    {
        $this->validate();

        $this->blog->update(
            $this->only([
                'title',
                'slug',
                'blog_category_id',
                'content'
            ])
        );

        flash()->success('Blog berhasil dibuat.');
    }

    public function render()
    {
        return view('livewire.blog-edit', [
            'categories' => BlogCategory::get(),
        ]);
    }
}
