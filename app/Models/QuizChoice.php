<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizChoice extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('quizOption');
    }
    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';
        
        return match ($eventName) {
            'created' => "[{$actor}] membuat opsi \"{$this->answer_option}\"",
            'updated' => "[{$actor}] memperbarui opsi \"{$this->answer_option}\"",
            'deleted' => "[{$actor}] menghapus opsi \"{$this->answer_option}\"",
            default => ucfirst($eventName) . " opsi \"{$this->answer_option}\"",
        };
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'answer_option',
        'is_correct',
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
            'question_id' => 'integer',
            'is_correct' => 'boolean',
        ];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}
