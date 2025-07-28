<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseContent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_syllabus_id',
        'title',
        'content',
        'video_url',
        'order',
        'is_free_preview',
        'is_assessment',
        'is_completed',
        'quiz_id',
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
            'is_assessment' => 'boolean',
            'is_completed' => 'boolean',
        ];
    }

    public function courseSyllabus(): BelongsTo
    {
        return $this->belongsTo(\App\Models\CourseSyllabus::class);
    }
    public function quiz(){
        return $this->hasOne(Quiz::class);
    }
}
