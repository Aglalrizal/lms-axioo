<?php

namespace App\Livewire;

use App\Models\Blog;
use App\Models\BlogCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]

class BlogIndexPublic extends Component
{
    use WithPagination;

    // protected $paginationTheme = 'bootstrap';

    public $isShowing = 'berita';

    public function setShow(string $category): void
    {
        $this->isShowing = $category;
        $this->resetPage(pageName: 'posts_page');
    }

    public function render()
    {
        return view('livewire.blog-index-public', [
            'blogs' => Blog::query()
                ->select('id', 'title', 'slug', 'excerpt', 'photo_path', 'created_at', 'user_id', 'blog_category_id')
                ->with(['author:id,username', 'category:id,name'])
                ->whereRelation('category', 'name', $this->isShowing)
                ->where('status', 'published')
                ->orderBy('created_at', 'desc')
                ->paginate(9, pageName: 'posts_page'),
            // 'categories' => BlogCategory::all()
        ]);
    }
}
