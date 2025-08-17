<?php

namespace App\Livewire;

use App\Models\ContactUs;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]

class ContactUsIndex extends Component
{
    use WithPagination;

    // protected $paginationTheme = 'bootstrap';

    public $isShowing = 'all';
    public $query = '';
    public $messageId;
    public $messageAction;

    public function setShow(string $status): void
    {
        $this->isShowing = $status;
        $this->resetPage(pageName: 'inbox_page');
    }

    public function search()
    {
        // Refresh component when searching
        $this->resetPage();
    }

    public function confirmation($id, $action)
    {
        $this->messageId = $id;
        $this->messageAction = $action;

        $aksi = $action === 'delete' ? 'menghapus' : 'memulihkan';

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Yes, ' . $aksi . ' it!')
            ->option('denyButtonText', 'Cancel')
            ->option('id', $id)
            ->warning('Apakah kamu yakin ingin ' . $aksi . ' pesan ini?');
    }

    #[On('sweetalert:confirmed')]
    public function actionOnConfirm()
    {
        if ($this->messageAction === 'delete') {
            ContactUs::findOrFail($this->messageId)->delete();
            flash()->success('Pesan berhasil dihapus.');
        } else {
            ContactUs::withTrashed()->findOrFail($this->messageId)->restore();
            flash()->success('Pesan berhasil dipulihkan.');
        }
    }

    #[On('sweetalert:denied')]
    public function actionOnCancel()
    {
        $this->messageId = null;
        $this->messageAction = null;
    }

    public function render()
    {
        $query = ContactUs::query();

        if ($this->isShowing === 'deleted') {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');

            if ($this->isShowing !== 'all') {
                $query->where('status', $this->isShowing);
            }
        }

        return view('livewire.contact-us-index', [
            'messages' => $query
                ->whereAny(['full_name', 'email'], 'like', '%' . $this->query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10, pageName: 'messages_page'),
        ]);
    }
}
