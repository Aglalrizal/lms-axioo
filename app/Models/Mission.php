<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_us_id',
        'title',
        'description'
    ];

    public function aboutUs(): BelongsTo
    {
        return $this->belongsTo(AboutUs::class);
    }
}
