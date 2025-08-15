<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseContent extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_syllabus_id',
        'title',
        'order',
        'type',
        'is_free_preview',
        'created_by',
        'modified_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'course_syllabus_id' => 'integer',
            'is_free_preview' => 'boolean',
        ];
    }

    public function courseSyllabus(): BelongsTo
    {
        return $this->belongsTo(\App\Models\CourseSyllabus::class);
    }
    public function quiz(){
        return $this->hasOne(Quiz::class);
    }
    public function article(){
        return $this->hasOne(Article::class);
    }
    public function video(){
        return $this->hasOne(Video::class);
    }
    public function assignment(){
        return $this->hasOne(Assignment::class);
    }
}
