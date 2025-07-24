<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BlogCategory;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Reactive;

class BlogEdit extends Component
{
    // #[Reactive]
    public $blog;
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
                Rule::unique('blogs')->ignore($this->blog),
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

    public function mount($blog)
    {
        $this->title = $blog->title;
        $this->slug = $blog->slug;
        $this->blog_category_id = $blog->blog_category_id;
        $this->content = $blog->content;

        $this->blog = $blog->load('author');
    }

    public function update()
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

        $this->resetExcept('blog');
    }

    public function render()
    {
        return view('livewire.blog-edit', [
            'categories' => BlogCategory::get(),
        ]);
    }
}
