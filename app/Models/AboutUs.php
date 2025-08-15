<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AboutUs extends Model
{
    protected $table = 'about_us';

    protected $fillable = [
        'about_description',
        'vision_description'
    ];

    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class);
    }
}
