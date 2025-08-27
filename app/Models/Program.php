<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    use  SoftDeletes, Sluggable;
    protected $fillable = ['name', 'image_path', 'slug'];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
