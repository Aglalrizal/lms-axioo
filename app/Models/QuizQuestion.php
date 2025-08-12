<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizQuestion extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('quizQuestion');
    }
    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';
        
        return match ($eventName) {
            'created' => "[{$actor}] membuat pertanyaan \"{$this->question}\"",
            'updated' => "[{$actor}] memperbarui pertanyaan \"{$this->question}\"",
            'deleted' => "[{$actor}] menghapus pertanyaan \"{$this->question}\"",
            default => ucfirst($eventName) . " pertanyaan \"{$this->question}\"",
        };
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id',
        'question',
        'question_type',
        'score',
        'order',
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
            'quiz_id' => 'integer',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
    public function choices(){
        return $this->hasMany(QuizChoice::class, 'question_id');
    }
}
