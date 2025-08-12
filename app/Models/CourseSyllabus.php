<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class CourseSyllabus extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'title',
        'order',
        'is_completed',
        'created_by',
        'modified_by',
    ];

    function getActivitylogOptions(): LogOptions
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
            default => ucfirst($eventName) . " silabus \"{$this->title}\"",
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
            'course_id' => 'integer',
            'is_completed' => 'boolean',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    public function contents(){
        return $this->hasMany(CourseContent::class);
    }
}
