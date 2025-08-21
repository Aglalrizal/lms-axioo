<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Mail\SupportTicketReplyMail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;

#[Layout('layouts.dashboard')]

class SupportTicketShow extends Component
{
    public ?SupportTicket $ticket;

    #[Validate('required|in:open,resolved,closed')]
    public $status;
    #[Validate('required|string|min:10')]
    public $replyMessage = '';

    #[Validate('required|string')]
    public $adminName = '';

    public $showReplyForm = false;

    public function mount()
    {
        $this->status = $this->ticket->status;
        $this->ticket->load('reply');

        // Set default admin name (bisa disesuaikan dengan auth user)
        $this->adminName = 'Support Team';
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
        if ($this->ticket->reply) {
            flash()->error('Ticket ini sudah memiliki balasan. Satu ticket hanya bisa dibalas sekali.');
            return;
        }

        // Create the reply
        $reply = SupportTicketReply::create([
            'support_ticket_id' => $this->ticket->id,
            'admin_name' => $this->adminName,
            'message' => $this->replyMessage,
            'sent_at' => now(),
            'email_status' => SupportTicketReply::EMAIL_STATUS_PENDING,
        ]);

        // Update ticket status to resolved
        $this->ticket->update(['status' => 'resolved']);
        $this->status = 'resolved';

        // Send email
        $this->sendEmailToCustomer($reply);

        // Reset form
        $this->reset(['replyMessage', 'showReplyForm']);
        $this->resetValidation();

        // Reload ticket with reply
        $this->ticket->load('reply');
    }

    private function sendEmailToCustomer($reply)
    {
        try {
            Mail::to($this->ticket->email)->send(new SupportTicketReplyMail($this->ticket, $reply));
            $reply->update(['email_status' => SupportTicketReply::EMAIL_STATUS_SENT]);
            flash()->success('Reply berhasil disimpan dan email telah dikirim ke customer.');
        } catch (\Exception $e) {
            $reply->update(['email_status' => SupportTicketReply::EMAIL_STATUS_FAILED]);
            flash()->warning('Reply berhasil disimpan tetapi terjadi masalah saat mengirim email: ' . $e->getMessage());
        }
    }

    public function resendEmail()
    {
        if (!$this->ticket->reply) {
            flash()->error('Tidak ada balasan untuk dikirim ulang.');
            return;
        }

        if ($this->ticket->reply->isEmailSent()) {
            flash()->info('Email sudah berhasil dikirim sebelumnya.');
            return;
        }

        $this->sendEmailToCustomer($this->ticket->reply);
        $this->ticket->load('reply');
    }

    public function updateStatus()
    {
        $this->validateOnly('status');

        $this->ticket->update(
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
