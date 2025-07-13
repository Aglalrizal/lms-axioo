<?php

namespace App\Livewire;

use App\Models\SupportTicket;
use Livewire\Component;
use Livewire\WithPagination;


class SupportTicketIndex extends Component
{
    use WithPagination;

    public $isShowing = 'all';

    public function setShow(string $status): void
    {
        $this->isShowing = $status;
        $this->resetPage(pageName: 'tickets_page');
    }

    public function softDelete(SupportTicket $ticket)
    {
        $ticket->delete();
    }

    // public function restore(SupportTicket $ticket)
    // {
    //     $ticket->restore();
    // }

    public function restore(int $ticketId): void
    {
        $ticket = SupportTicket::withTrashed()->find($ticketId);

        $ticket->restore();
    }

    public function render()
    {
        $query = SupportTicket::query();

        if ($this->isShowing === 'deleted') {
            $query->onlyTrashed();
        } else {
            $query->whereNull('deleted_at');

            if ($this->isShowing !== 'all') {
                $query->where('status', $this->isShowing);
            }
        }

        return view('livewire.support-ticket-index', [
            'tickets' => $query
                ->orderBy('created_at', 'desc')
                ->simplePaginate(10, pageName: 'tickets_page'),
        ]);
    }
}
