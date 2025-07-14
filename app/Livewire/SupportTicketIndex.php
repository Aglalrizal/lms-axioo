<?php

namespace App\Livewire;

use App\Models\SupportTicket;
use Livewire\Component;
use Livewire\Features\SupportPagination\HandlesPagination;
use Livewire\WithPagination;


class SupportTicketIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $isShowing = 'all';
    public $query = '';

    public function setShow(string $status): void
    {
        $this->isShowing = $status;
        $this->resetPage(pageName: 'tickets_page');
    }

    public function search()
    {
        $this->resetPage();
    }

    public function softDelete(SupportTicket $ticket)
    {
        $ticket->delete();
    }

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
                ->whereAny(['title', 'email'], 'ilike', '%' . $this->query . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10, pageName: 'tickets_page'),
        ]);
    }
}
