<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Quiz extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('kuis');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'Sistem';
        $title = $this?->courseContent()->title ?? 'Kuis';

        return match ($eventName) {
            'created' => "[{$actor}] membuat kuis \"{$title}\"",
            'updated' => "[{$actor}] memperbarui kuis \"{$title}\"",
            'deleted' => "[{$actor}] menghapus kuis \"{$title}\"",
            default => ucfirst($eventName)." kuis \"{$title}\"",
        };
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_content_id',
        'description',
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
        return $this->belongsTo(\App\Models\CourseContent::class, 'course_content_id');
    }

    public function questions()
    {
        return $this->hasMany(\App\Models\QuizQuestion::class);
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
