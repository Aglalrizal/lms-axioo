<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;
use Flasher\SweetAlert\Laravel\Facade\SweetAlert;

class BlogIndexAdmin extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $isShowing = 'all';
    public $query = '';

    public function setShow(string $status): void
    {
        $this->isShowing = $status;
        $this->resetPage(pageName: 'posts_page');
    }

    public function search()
    {
        $this->resetPage();
    }

    public function softDelete(Blog $blog)
    {
        $blog->delete();
        SweetAlert::success('Ticket deleted successfully.');
    }

    public function restore(int $blogId): void
    {
        $blog = Blog::withTrashed()->find($blogId);
        $blog->restore();
        SweetAlert::success('Ticket restored successfully.');
    }

    public function render()
    {
        $query = Blog::query();

        if ($this->isShowing === 'deleted') {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');

            if ($this->isShowing !== 'all') {
                $query->where('status', $this->isShowing);
            }
        }

        return view('livewire.blog-index-admin', [
            'blogs' => $query
                ->with(['author', 'category'])
                ->whereAny(['title'], 'like', '%' . $this->query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10, pageName: 'posts_page'),
        ]);
    }
}
