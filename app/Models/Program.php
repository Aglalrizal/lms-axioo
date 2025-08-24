<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    use  SoftDeletes;
    protected $fillable = ['name', 'image_path', 'slug'];
    public function course()
    {
        return $this->hasOne(Course::class);
    }
}
