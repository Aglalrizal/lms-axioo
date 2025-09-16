<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LearningPath extends Model
{
    use HasFactory, LogsActivity, Sluggable, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image_path',
        'is_published',
        'created_by',
        'modified_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * Activity log configuration
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('learning_path');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';

        return match ($eventName) {
            'created' => "[{$actor}] membuat learning path \"{$this->title}\"",
            'updated' => "[{$actor}] memperbarui learning path \"{$this->title}\"",
            'deleted' => "[{$actor}] menghapus learning path \"{$this->title}\"",
            default => ucfirst($eventName)." learning path \"{$this->title}\"",
        };
    }

    /**
     * Relationships
     */
    public function steps()
    {
        return $this->hasMany(LearningPathStep::class)->orderBy('order');
    }

    public function courses()
    {
        return $this->hasManyThrough(Course::class, LearningPathStep::class, 'learning_path_id', 'id', 'id', 'course_id');
    }
}
