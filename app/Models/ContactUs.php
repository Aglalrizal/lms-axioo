<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use  HasFactory, SoftDeletes;

    protected $table = 'contact_us';

    protected $fillable = [
        'full_name',
        'email',
        'message',
        'status',
    ];

    public function reply()
    {
        return $this->hasOne(ContactUsReply::class);
    }
}
