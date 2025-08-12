<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseContent extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('courseContent');
    }
    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';
        
        return match ($eventName) {
            'created' => "[{$actor}] membuat kontent kursus \"{$this->title}\"",
            'updated' => "[{$actor}] memperbarui kontent kursus \"{$this->title}\"",
            'deleted' => "[{$actor}] menghapus kontent kursus \"{$this->title}\"",
            default => ucfirst($eventName) . " kontent kursus \"{$this->title}\"",
        };
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_syllabus_id',
        'title',
        'content',
        'video_url',
        'order',
        'is_free_preview',
        'is_assessment',
        'is_completed',
        'quiz_id',
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
            'course_syllabus_id' => 'integer',
            'is_free_preview' => 'boolean',
            'is_assessment' => 'boolean',
            'is_completed' => 'boolean',
        ];
    }

    public function courseSyllabus(): BelongsTo
    {
        return $this->belongsTo(\App\Models\CourseSyllabus::class);
    }
    public function quiz(){
        return $this->hasOne(Quiz::class);
    }
}
