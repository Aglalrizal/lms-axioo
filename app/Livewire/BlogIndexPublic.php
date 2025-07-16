<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;
use Flasher\SweetAlert\Laravel\Facade\SweetAlert;

class BlogIndexPublic extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $isShowing = 'berita';


    public function setShow(string $category): void
    {
        $this->isShowing = $category;
        $this->resetPage(pageName: 'posts_page');
    }

    public function render()
    {
        return view('livewire.blog-index-public', [
            'blogs' => Blog::with(['author', 'category'])
                ->whereRelation('category', 'name', $this->isShowing)
                ->orderBy('created_at', 'desc')
                ->paginate(9, pageName: 'posts_page'),
        ]);
    }
}
