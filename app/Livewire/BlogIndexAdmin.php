<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class BlogIndexAdmin extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $isShowing = 'all';
    public $query = '';
    public $blogId;

    public function setShow(string $status): void
    {
        $this->isShowing = $status;
        $this->resetPage(pageName: 'posts_page');
    }

    public function search()
    {
        $this->resetPage();
    }

    public function confirmation($id)
    {
        $this->blogId = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Yes, delete it!')
            ->option('denyButtonText', 'Cancel')
            ->option('id', $id)
            ->warning('Are you sure you want to delete this blog?');
    }

    #[On('sweetalert:confirmed')]
    public function actionOnConfirm()
    {
        Blog::findOrFail($this->blogId)->delete();
        flash()->success('Ticket deleted successfully.');
    }

    #[On('sweetalert:denied')]
    public function actionOnCancel()
    {
        $this->blogId = null;

        flash()->info('Blog deletion cancelled.');
    }


    public function render()
    {
        $query = Blog::query();

        if ($this->isShowing !== 'all') {
            $query->where('status', $this->isShowing);
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
