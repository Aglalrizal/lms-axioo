<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizAttempt extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id',
        'user_id',
        'start_time',
        'end_time',
        'total_score',
        'status',
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
            'quiz_id' => 'integer',
            'user_id' => 'integer',
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }
    public function getTimeLeftAttribute(): int
    {
        return max(0, now()->diffInSeconds($this->end_time, false));
    }
    public function getPercentageAttribute(){
        $number_of_questions = $this->quiz->questions->count();
        if ($number_of_questions === 0) {
            return 0;
        }
        return round(($this->total_score / $number_of_questions) * 100, 1);
    }
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function answers(){
        return $this->hasMany(QuizAnswer::class);
    }
}
