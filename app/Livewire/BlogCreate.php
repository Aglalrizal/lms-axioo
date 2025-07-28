<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class BlogCreate extends Component
{
    // public $date;
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
            'content' => 'required'
        ];
    }

    public function submit()
    {
        $validatedData = $this->validate();

        // dd($this->content);

        $userId = Auth::id();

        $blogData = array_merge($validatedData, [
            'user_id' => $userId,
        ]);

        Blog::create($blogData);

        $this->reset();

        flash()->success('Blog berhasil dibuat.');
    }

    public function render()
    {
        return view(
            'livewire.blog-create',
            [
                'categories' => BlogCategory::get()
            ]
        );
    }
}
