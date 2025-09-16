<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    /** @use HasFactory<\Database\Factories\CourseProgressFactory> */
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'course_content_id',
        'is_completed',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function content()
    {
        return $this->belongsTo(CourseContent::class, 'course_content_id');
    }
}
