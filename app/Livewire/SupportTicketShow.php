<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\SupportTicket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

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
        $this->ticket->delete();

        $this->redirect(route('admin.support-ticket.index'));
    }


    public function render()
    {
        return view('livewire.support-ticket-show');
    }
}
