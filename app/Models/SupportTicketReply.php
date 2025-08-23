<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicketReply extends Model
{
    const EMAIL_STATUS_PENDING = 'pending';
    const EMAIL_STATUS_SENT = 'sent';
    const EMAIL_STATUS_FAILED = 'failed';

    protected $fillable = [
        'support_ticket_id',
        'admin_name',
        'message',
        'sent_at',
        'email_status',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class);
    }

    public function isEmailSent()
    {
        return $this->email_status === self::EMAIL_STATUS_SENT;
    }
}
