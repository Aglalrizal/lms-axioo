<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;
    protected $fillable = ['course_id', 'student_id', 'price', 'quantity', 'status'];
    public function course(){
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }
}
