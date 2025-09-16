<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $fillable = [
        'assignment_id',
        'student_id',
        'content',
        'url',
        'file_path',
        'status',
        'grade',
        'feedback',
        'graded_by',
        'submitted_at',
        'graded_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
    ];

    public function getStatusFormattedAttribute()
    {
        return match ($this->status) {
            'submitted' => 'Belum diperiksa',
            'under review' => 'Sedang diperiksa',
            'graded' => 'Sudah diperiksa',
            'late' => 'Terlambat'
        };
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function grader()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}
