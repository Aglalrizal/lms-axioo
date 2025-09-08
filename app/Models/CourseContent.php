<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\CourseContentObserver;

#[ObservedBy([CourseContentObserver::class])]
class CourseContent extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'course_syllabus_id',
        'title',
        'order',
        'type',
        'is_free_preview',
        'created_by',
        'modified_by',
        'global_order'
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
        ];
    }

    public static function recalculateGlobalOrder($courseId)
    {
        $contents = self::where('course_id', $courseId)
            ->orderBy('course_syllabus_id')
            ->orderBy('order')
            ->get();

        $globalOrder = 1;
        foreach ($contents as $content) {
            $content->updateQuietly(['global_order' => $globalOrder++]);
        }
    }

    public function getIconAttribute()
    {
        return match ($this->type) {
            'article' => 'bi-book',
            'video'   => 'bi-play-fill',
            'quiz'    => 'bi-question-lg',
            'assignment'   => 'bi-file-earmark-fill',
            default     => 'bi-book'
        };
    }
    public function getTypeFormattedAttribute()
    {
        return match ($this->type) {
            'article' => 'artikel',
            'video'   => 'video',
            'quiz'    => 'kuis',
            'assignment'   => 'tugas',
            default     => 'bi-book'
        };
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function courseSyllabus(): BelongsTo
    {
        return $this->belongsTo(\App\Models\CourseSyllabus::class);
    }
    public function quiz(){
        return $this->hasOne(Quiz::class);
    }
    public function article(){
        return $this->hasOne(Article::class);
    }
    public function video(){
        return $this->hasOne(Video::class);
    }
    public function assignment(){
        return $this->hasOne(Assignment::class);
    }
    public function getIsUnlockedAttribute()
    {
        $user = User::find(Auth::id());
        if (!$user) {
            return false; 
        }

        $allContents = $this->course
            ->contents()
            ->orderBy('global_order')
            ->get();

        $completedIds = $user->progresses()
            ->where('course_id', $this->course_id)
            ->where('is_completed', true)
            ->pluck('course_content_id')
            ->toArray();

        $index = $allContents->search(fn ($c) => $c->id === $this->id);

        if ($index === 0) {
            return true;
        }

        $previous = $allContents[$index - 1];

        return in_array($previous->id, $completedIds);
    }
    public function progresses()
    {
        return $this->hasMany(CourseProgress::class);
    }

    public function completedBy()
    {
        return $this->belongsToMany(User::class, 'course_progress', 'content_id', 'student_id')
                    ->withPivot('is_completed');
    }
}
