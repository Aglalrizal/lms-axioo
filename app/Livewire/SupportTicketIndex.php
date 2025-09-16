<?php

namespace App\Livewire;

use App\Enums\TicketStatus;
use App\Models\SupportTicket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]

class SupportTicketIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $isShowing = 'all';

    public $query = '';

    public $ticketId;

    public $ticketAction;

    public function setShow(string $status): void
    {
        $this->isShowing = $status;
        $this->resetPage('tickets_page');
    }

    public function search()
    {
        // Refresh component when searching
        $this->resetPage('tickets_page');
    }

    public function confirmation($id, $action)
    {
        $this->ticketId = $id;
        $this->ticketAction = $action;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Yes, '.$action.' it!')
            ->option('denyButtonText', 'Cancel')
            ->option('id', $id)
            ->warning('Are you sure you want to '.$action.' this ticket?');
    }

    #[On('sweetalert:confirmed')]
    public function actionOnConfirm()
    {
        if ($this->ticketAction === 'delete') {
            SupportTicket::findOrFail($this->ticketId)->delete();
            flash()->success('Ticket deleted successfully.');
        } else {
            SupportTicket::withTrashed()->findOrFail($this->ticketId)->restore();
            flash()->success('Ticket restored successfully.');
        }
    }

    #[On('sweetalert:denied')]
    public function actionOnCancel()
    {
        $this->ticketId = null;
        $this->ticketAction = null;
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
                ->whereAny(['title', 'email'], 'like', '%'.$this->query.'%')
                ->orderBy('created_at', 'desc')
                ->select('id', 'title', 'email', 'created_at', 'status', 'subject')
                ->paginate(10, pageName: 'tickets_page'),
            'statuses' => TicketStatus::toArray(),
        ]);
    }
}
