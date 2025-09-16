<?php

namespace App\Models;

use App\Enums\AccessType;
use App\Enums\CourseLevel;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Course extends Model
{
    use HasFactory, LogsActivity, Sluggable, SoftDeletes;

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

    public function getActivitylogOptions(): LogOptions
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
            default => ucfirst($eventName)." course \"{$this->title}\"",
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
        'access_type',
        'price',
        'duration',
        'extra_description',
        'is_published',
        'created_by',
        'modified_by',
        'short_desc',
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
            'access_type' => AccessType::class,
            'level' => CourseLevel::class,
        ];
    }

    public function getPriceFormattedAttribute()
    {
        if (is_null($this->price) || $this->price == 0) {
            return 'Gratis';
        }

        return 'Rp '.number_format($this->price, 0, ',', '.');
    }

    // public function getLevelFormattedAttribute(){
    //     return match ($this->level){
    //         'beginner' => 'Pemula',
    //         'intermediate' => 'Menengah',
    //         'advanced' => 'Mahir'
    //     };
    // }
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function program()
    {
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

    public function progresses()
    {
        return $this->hasMany(CourseProgress::class);
    }

    public function studentProgress()
    {
        return $this->belongsToMany(User::class, 'course_progress', 'course_id', 'student_id')
            ->withPivot('is_completed');
    }
}
