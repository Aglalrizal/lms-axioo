<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUsReply extends Model
{
    protected $fillable = [
        'contact_us_id',
        'admin_name',
        'message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function contactUs()
    {
        return $this->belongsTo(ContactUs::class);
    }
}
