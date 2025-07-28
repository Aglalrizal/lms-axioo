<?php

namespace App\Livewire;

use App\Models\SupportTicket;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SupportTicketCreate extends Component
{
    #[Validate('required|string|max:64|min:3')]
    public $full_name;
    #[Validate('required|email')]
    public $email;
    #[Validate('required|string|max:64|min:5')]
    public $title;
    #[Validate('required|in:General,Technical,Accounts,Payment,Other')]
    public $subject;
    #[Validate('required|string|max:2000|min:32')]
    public $description;

    public function submit()
    {
        $this->validate();

        SupportTicket::create($this->only([
            'title',
            'full_name',
            'email',
            'subject',
            'description',
        ]));

        sweetalert()->success('Tiket berhasil dikirim.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.support-ticket-create');
    }
}
