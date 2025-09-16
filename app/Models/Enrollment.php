<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    /** @use HasFactory<\Database\Factories\EnrollmentFactory> */
    use HasFactory;

    protected $fillable = ['transaction_id', 'student_id', 'course_id', 'enrolled_by', 'enrolled_at', 'created_by', 'modified_by'];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrolledBy()
    {
        return $this->belongsTo(User::class, 'enrolled_by', 'username');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'username');
    }

    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by', 'username');
    }
}
