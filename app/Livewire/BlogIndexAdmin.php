<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use App\Enums\BlogStatus;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]

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
                ->select('id', 'title', 'slug', 'status', 'created_at', 'updated_at', 'user_id', 'blog_category_id')
                ->with(['author:id,username', 'category:id,name'])
                ->whereAny(['title'], 'like', '%' . $this->query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10, pageName: 'posts_page'),
            'statuses' => BlogStatus::toArray()
        ]);
    }
}
