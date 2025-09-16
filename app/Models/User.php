<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, LogsActivity, Notifiable, SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logExcept(['password'])
            ->useLogName('user');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = Auth::user()?->username ?? 'System';

        return match ($eventName) {
            'created' => "[{$actor}] membuat user \"{$this->username}\"",
            'updated' => "[{$actor}] memperbarui user \"{$this->username}\"",
            'deleted' => "[{$actor}] menghapus user \"{$this->username}\"",
            default => ucfirst($eventName)." user \"{$this->username}\"",
        };
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'profile_picture_path',
        'id_number',
        'phone_number',
        'first_name',
        'surname',
        'date_of_birth',
        'place_of_birth',
        'city',
        'address',
        'education',
        'institution',
        'major',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'provider_token',
        'provider_refresh_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->surname}");
    }

    public function getAvatarUrlAttribute()
    {
        return $this->profile_picture_path
            ? asset('storage/'.$this->profile_picture_path)
            : 'https://ui-avatars.com/api/?background=random&name='.urlencode(optional($this)->full_name);
    }

    public function posts()
    {
        return $this->hasMany(Blog::class);
    }

    public function studyPlans()
    {
        return $this->hasMany(StudyPlan::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id');
    }

    public function assignmentSubmissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'student_id');
    }

    public function gradedSubmissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'graded_by');
    }

    public function progresses()
    {
        return $this->hasMany(CourseProgress::class, 'student_id');
    }

    public function completedContents()
    {
        return $this->progresses()->where('is_completed', true);
    }

    public function courseProgressInformation()
    {
        return $this->enrolledCourses()
            ->select('courses.id', 'courses.slug', 'courses.thumbnail', 'courses.title', 'courses.level', 'courses.duration', 'courses.program_id')
            ->with('program:id,name')
            ->withCount('contents as total_contents')
            ->withCount(['progresses as completed_contents' => function ($query) {
                $query->where('student_id', Auth::id());
                $query->where('is_completed', true);
            }])
            ->addSelect([
                'last_progress' => CourseProgress::query()->select('course_content_id')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('student_id', Auth::id())
                    ->latest()
                    ->take(1),
            ])
            ->orderBy('last_progress', 'desc');
    }

    /**
     * Menganalisis preferensi program berdasarkan enrollment history
     * Returns collection dengan program_id dan weight (berapa kali di-enroll)
     */
    public function getPreferredPrograms()
    {
        return Course::query()
            ->join('enrollments', 'courses.id', '=', 'enrollments.course_id')
            ->where('enrollments.student_id', $this->id)
            ->select('courses.program_id')
            ->selectRaw('COUNT(*) as enrollment_count')
            ->groupBy('courses.program_id')
            ->orderByDesc('enrollment_count')
            ->get()
            ->mapWithKeys(function ($item) {
                $program = Program::select('id', 'name')->find($item->program_id);

                return [$item->program_id => [
                    'count' => $item->enrollment_count,
                    'weight' => $item->enrollment_count,
                    'program' => $program,
                ]];
            });
    }

    /**
     * Menganalisis preferensi kategori berdasarkan enrollment history
     * Returns collection dengan category_id dan weight (berapa kali di-enroll)
     */
    public function getPreferredCategories()
    {
        return Course::query()
            ->join('enrollments', 'courses.id', '=', 'enrollments.course_id')
            ->where('enrollments.student_id', $this->id)
            ->select('courses.course_category_id')
            ->selectRaw('COUNT(*) as enrollment_count')
            ->groupBy('courses.course_category_id')
            ->orderByDesc('enrollment_count')
            ->get()
            ->mapWithKeys(function ($item) {
                $category = CourseCategory::select('id', 'name')->find($item->course_category_id);

                return [$item->course_category_id => [
                    'count' => $item->enrollment_count,
                    'weight' => $item->enrollment_count,
                    'category' => $category,
                ]];
            });
    }

    /**
     * Generate course recommendations berdasarkan program dan category preferences
     */
    public function getIntelligentRecommendations($limit = 4)
    {
        $preferredPrograms = $this->getPreferredPrograms();
        $preferredCategories = $this->getPreferredCategories();

        // Jika user belum punya enrollment history, return random courses
        if ($preferredPrograms->isEmpty() && $preferredCategories->isEmpty()) {
            return Course::query()
                ->whereDoesntHave('enrollments', function ($q) {
                    $q->where('student_id', $this->id);
                })
                ->where('is_published', true)
                ->select('id', 'title', 'thumbnail', 'level', 'access_type', 'program_id', 'course_category_id', 'short_desc', 'slug', 'duration')
                ->with(['program:id,name', 'courseCategory:id,name'])
                ->inRandomOrder()
                ->limit($limit)
                ->get();
        }

        // Scoring algorithm berdasarkan preferensi
        // Hindari query berulang: hitung sekali jumlah course yang pernah di-enroll user
        $enrolledCoursesCount = $this->enrolled_courses_count ?? $this->enrolledCourses()->count();

        $courses = Course::query()
            ->whereDoesntHave('enrollments', function ($q) {
                $q->where('student_id', $this->id);
            })
            ->where('is_published', true)
            ->select('id', 'title', 'thumbnail', 'level', 'access_type', 'program_id', 'course_category_id', 'short_desc', 'slug', 'duration')
            ->with(['program:id,name', 'courseCategory:id,name'])
            ->get()
            ->map(function ($course) use ($preferredPrograms, $preferredCategories, $enrolledCoursesCount) {
                $score = 0;

                $programWeights = 0.6; // Bobot untuk preferensi program
                $categoryWeights = 0.4; // Bobot untuk preferensi kategori
                $levelWeights = 0; // Bobot untuk level course
                $accessTypeWeights = 0; // Bobot untuk tipe akses (free

                // Program weight (40% of total score)
                if ($preferredPrograms->has($course->program_id)) {
                    $score += $preferredPrograms[$course->program_id]['weight'] * $programWeights;
                }

                // Category weight (30% of total score)
                if ($preferredCategories->has($course->course_category_id)) {
                    $score += $preferredCategories[$course->course_category_id]['weight'] * $categoryWeights;
                }

                // Level compatibility (20% of total score)
                // Berikan bonus untuk level yang sesuai dengan progress user
                $completedCourses = $enrolledCoursesCount;
                if ($completedCourses <= 2 && $course->level->value === 'beginner') {
                    $score += 2 * $levelWeights;
                } elseif ($completedCourses > 2 && $completedCourses <= 5 && $course->level->value === 'intermediate') {
                    $score += 2 * $levelWeights;
                } elseif ($completedCourses > 5 && $course->level->value === 'advanced') {
                    $score += 2 * $levelWeights;
                }

                // Access type bonus (10% of total score)
                // Berikan preferensi sedikit untuk free courses
                if ($course->access_type->value === 'free') {
                    $score += 1 * $accessTypeWeights;
                }

                $course->recommendation_score = $score;

                return $course;
            })
            ->sortByDesc('recommendation_score')
            ->take($limit);

        return $courses->values();
    }
}
