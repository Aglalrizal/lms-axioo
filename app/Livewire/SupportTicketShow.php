<?php

namespace App\Livewire;

use App\Models\SupportTicket;
use Livewire\Component;

class SupportTicketShow extends Component
{
    public $ticket;

    public function mount($ticket = null)
    {
        $this->ticket = $ticket;
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
