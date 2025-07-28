<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_content_id',
        'title',
        'duration',
        'number_of_questions',
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
            'course_content_id' => 'integer',
        ];
    }

    public function courseContent(): BelongsTo
    {
        return $this->belongsTo(\App\Models\CourseContent::class);
    }
    public function questions() {
        return $this->hasMany(\App\Models\QuizQuestion::class);
    }
}
