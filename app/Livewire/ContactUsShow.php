<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ContactUs;
use App\Models\ContactUsReply;
use App\Mail\ContactUsReplyMail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;

#[Layout('layouts.dashboard')]

class ContactUsShow extends Component
{
    public ?ContactUs $contactUs;

    #[Validate('required|in:open,replied')]
    public $status;
    #[Validate('required|string|min:10')]
    public $replyMessage = '';

    #[Validate('required|string')]
    public $adminName = '';

    public $showReplyForm = false;

    public function mount()
    {
        $this->status = $this->contactUs->status;
        $this->contactUs->load('reply');

        // Set default admin name (bisa disesuaikan dengan auth user)
        $this->adminName = 'Customer Service Team';
    }

    public function toggleReplyForm()
    {
        $this->showReplyForm = !$this->showReplyForm;

        if (!$this->showReplyForm) {
            $this->reset(['replyMessage']);
            $this->resetValidation();
        }
    }

    public function sendReply()
    {
        $this->validateOnly(
            'replyMessage|adminName'
        );

        // Check if reply already exists
        if ($this->contactUs->reply) {
            flash()->error('Pesan ini sudah memiliki balasan. Satu pesan hanya bisa dibalas sekali.');
            return;
        }

        // Create the reply
        $reply = ContactUsReply::create([
            'contact_us_id' => $this->contactUs->id,
            'admin_name' => $this->adminName,
            'message' => $this->replyMessage,
            'sent_at' => now(),
        ]);

        // Update contact us status to replied
        $this->contactUs->update(['status' => 'replied']);
        $this->status = 'replied';

        // Send email
        try {
            Mail::to($this->contactUs->email)->send(new ContactUsReplyMail($this->contactUs, $reply));
            flash()->success('Reply berhasil dikirim dan email telah dikirim ke customer.');
        } catch (\Exception $e) {
            flash()->warning('Reply berhasil dikirim tetapi terjadi masalah saat mengirim email: ' . $e->getMessage());
        }

        // Reset form
        $this->reset(['replyMessage', 'showReplyForm']);
        $this->resetValidation();

        // Reload contact us with reply
        $this->contactUs->load('reply');
    }

    public function updateStatus()
    {
        $this->validateOnly('status');

        $this->contactUs->update(
            $this->only([
                'status'
            ])
        );

        flash()->success('Status berhasil diubah.');
    }

    public function confirmation()
    {
        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Ya, Hapus Pesan!')
            ->option('denyButtonText', 'Batal')
            ->warning('Apakah Anda yakin ingin menghapus pesan ini?');
    }

    #[On('sweetalert:confirmed')]
    public function softDelete()
    {
        $this->contactUs->delete();

        $this->redirect(route('admin.inbox.index'));
    }

    public function render()
    {
        return view('livewire.contact-us-show');
    }
}
