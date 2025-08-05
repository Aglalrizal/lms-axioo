<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SupportTicket;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout('layouts.app')]

class SupportTicketCreate extends Component
{
    #[Validate('required|string|max:64')]
    public $full_name;
    #[Validate('required|email')]
    public $email;
    #[Validate('required|string|max:64')]
    public $title;
    #[Validate('required|in:General,Technical,Accounts,Payment,Other')]
    public $subject;
    #[Validate('required|string|max:2000|min:32')]
    public $description;

    public function messages()
    {
        return [
            'full_name.required' => 'Nama lengkap diperlukan.',
            'full_name.max' => 'Nama lengkap tidak boleh lebih dari :value karakter.',
            'email.required' => 'Email diperlukan.',
            'title.required' => 'Judul diperlukan.',
            'subject.required' => 'Subjek diperlukan.',
            'description.required' => 'Deskripsi diperlukan.',
            'description.min' => 'Deskripsi harus terdiri dari minimal :value karakter.',
            'description.max' => 'Deskripsi tidak boleh lebih dari :value karakter.',
        ];
    }

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

        flash()->success('Tiket berhasil dikirim.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.support-ticket-create');
    }
}
