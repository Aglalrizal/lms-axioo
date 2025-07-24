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
            'title' => 'required|max:60|string',
            'slug' => [
                'required',
                'string',
                'max:72',
                Rule::unique('blogs')
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
            'title.required' => 'The :attribute are missing.',
            'title.max' => 'The :attribute is too large.',
            'slug.required' => 'The :attribute are missing.',
            'slug.max' => 'The :attribute is too large.',
            'slug.unique' => 'The :attribute has already been taken.',
            'content.required' => 'The :attribute are missing.',
        ];
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $validatedData['user_id'] = Auth::id();

        Blog::create($validatedData);

        flash()->success('Blog berhasil dibuat.');

        return $this->reset();
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
