<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    protected $table = 'our_teams';

    protected $fillable = [
        'nama',
        'deskripsi',
        'jabatan',
        'linkedin',
        'photo_path'
    ];
}
