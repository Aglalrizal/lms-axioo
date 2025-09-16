<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LearningPathStep extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'learning_path_id',
        'course_id',
        'title',
        'description',
        'order',
    ];

    protected $casts = [
        'learning_path_id' => 'integer',
        'course_id' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Activity log configuration
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('learning_path_step');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';

        return match ($eventName) {
            'created' => "[{$actor}] membuat step \"{$this->title}\"",
            'updated' => "[{$actor}] memperbarui step \"{$this->title}\"",
            'deleted' => "[{$actor}] menghapus step \"{$this->title}\"",
            default => ucfirst($eventName)." step \"{$this->title}\"",
        };
    }

    /**
     * Relationships
     */
    public function learningPath(): BelongsTo
    {
        return $this->belongsTo(LearningPath::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope untuk ordering
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
