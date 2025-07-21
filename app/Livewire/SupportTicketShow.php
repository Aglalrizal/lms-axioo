<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SupportTicket;
use Livewire\Attributes\Validate;

class SupportTicketShow extends Component
{
    public $ticket;

    #[Validate('required|in:open,in-progress,resolved,closed')]
    public $status;

    public function mount($ticket = null)
    {
        $this->ticket = $ticket;
        $this->status = $ticket->status;
    }

    public function updateStatus()
    {
        $this->validate();

        $this->ticket->update(
            $this->only([
                'status'
            ])
        );

        flash()->success('Status berhasi diubah.');
    }

    public function softDelete(SupportTicket $ticket)
    {
        $ticket->delete();

        $this->redirect(route('admin.support-ticket.index'));
    }


    public function render()
    {
        return view('livewire.support-ticket-show');
    }
}
