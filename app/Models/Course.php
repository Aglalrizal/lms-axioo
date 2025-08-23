<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Course extends Model
{
    use HasFactory, Sluggable, SoftDeletes, LogsActivity;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('course');
    }
    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';
        
        return match ($eventName) {
            'created' => "[{$actor}] membuat kursus \"{$this->title}\"",
            'updated' => "[{$actor}] memperbarui kursus \"{$this->title}\"",
            'deleted' => "[{$actor}] menghapus kursus \"{$this->title}\"",
            default => ucfirst($eventName) . " course \"{$this->title}\"",
        };
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'teacher_id',
        'program_id',
        'course_category_id',
        'description',
        'thumbnail',
        'level',
        'course_type',
        'price',
        'duration',
        'extra_description',
        'is_published',
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
            'teacher_id' => 'integer',
            'course_category_id' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function program(){
        return $this->belongsTo(Program::class);
    }
    public function courseCategory(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class);
    }
    public function syllabus()
    {
        return $this->hasMany(CourseSyllabus::class);
    }
    public function contents()
    {
        return $this->hasManyThrough(
            CourseContent::class,
            CourseSyllabus::class,
            'course_id',     
            'course_syllabus_id',
        );
    }
    public function hasAssignment(): bool
    {
        return $this->contents()
            ->where('type', 'assignment')
            ->withoutTrashed()
            ->exists();
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id')
                    ->withPivot(['transaction_id', 'enrolled_by', 'enrolled_at']);
    }
}
