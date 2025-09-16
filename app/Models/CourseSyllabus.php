<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CourseSyllabus extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'title',
        'order',
        'description',
        'is_completed',
        'created_by',
        'modified_by',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('syllabus');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';

        return match ($eventName) {
            'created' => "[{$actor}] membuat silabus \"{$this->title}\"",
            'updated' => "[{$actor}] memperbarui silabus \"{$this->title}\"",
            'deleted' => "[{$actor}] menghapus silabus \"{$this->title}\"",
            default => ucfirst($eventName)." silabus \"{$this->title}\"",
        };
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'title' => 'string',
            'order' => 'integer',
            'description' => 'string',
            'course_id' => 'integer',
            'is_completed' => 'boolean',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function courseContents()
    {
        return $this->hasMany(CourseContent::class);
    }

    public function hasAssignmentInCourse(): bool
    {
        return $this->course
            ->contents()
            ->where('type', 'assignment')
            ->withoutTrashed()
            ->exists();
    }
}
