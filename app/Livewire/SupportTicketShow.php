<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\SupportTicket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.dashboard')]

class SupportTicketShow extends Component
{
    public ?SupportTicket $ticket;

    #[Validate('required|in:open,in-progress,resolved,closed')]
    public $status;

    public function mount()
    {
        $this->status = $this->ticket->status;
    }

    private function roleCheck()
    {
        if (! Auth::user()->hasRole(['super-admin', 'admin'])) {
            abort(403);
        }
    }

    public function updateStatus()
    {
        $this->roleCheck();

        $this->validate();

        $this->ticket->update(
            $this->only([
                'status'
            ])
        );

        flash()->success('Status berhasi diubah.');
    }

    public function confirmation()
    {
        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Ya, Hapus Tiket!')
            ->option('denyButtonText', 'Batal')
            ->warning('Apakah Anda yakin ingin menghapus tiket ini?');
    }

    #[On('sweetalert:confirmed')]
    public function softDelete()
    {
        $this->roleCheck();

        $this->ticket->delete();

        $this->redirect(route('admin.support-ticket.index'));
    }


    public function render()
    {
        return view('livewire.support-ticket-show');
    }
}
