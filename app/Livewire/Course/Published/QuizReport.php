<?php

namespace App\Livewire\Course\Published;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class QuizReport extends Component
{
    use WithPagination;

    public Course $course;

    public ?string $slug = null;

    #[Url]
    public ?int $quiz_id = null;

    public ?Quiz $selectedQuiz = null;

    #[Url]
    public string $search = '';

    #[Url]
    public string $activeTab = 'participants';

    public int $totalQuestions = 0;

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($slug = null)
    {
        $this->slug = $slug;
        $this->course = Course::where('slug', $slug)
            ->with(['teacher', 'syllabus.courseContents'])
            ->firstOrFail();

        // Load the selected quiz (guaranteed to exist)
        $this->selectedQuiz = Quiz::with(['courseContent'])
            ->withCount('questions')
            ->whereHas('courseContent.courseSyllabus', function ($query) {
                $query->where('course_id', $this->course->id);
            })
            ->findOrFail($this->quiz_id);

        $this->totalQuestions = (int) ($this->selectedQuiz->questions_count ?? 0);
    }

    public function render()
    {
        $participants = collect();
        $totalParticipants = 0;
        $averageScore = 0;

        // Mencari percobaan dengan waktu paling baru per Pengguna
        $latestAttemptPerUser = QuizAttempt::query()
            ->selectRaw('user_id, MAX(updated_at) as max_updated_at')
            ->where('quiz_id', $this->selectedQuiz->id)
            ->whereIn('status', ['completed', 'graded'])
            ->groupBy('user_id');

        // mendapatkan id unik dari percobaan terakhir per pengguna bila terjadi
        // dua percobaan dengan updated_at yang sama persis (misalnya terjadi dalam satu detik yang sama)
        // $latestAttemptIdPerUser = QuizAttempt::query()
        //     ->selectRaw('quiz_attempts.user_id, MAX(quiz_attempts.id) as id')
        //     ->joinSub($latestAttemptPerUser, 'latest_by_time', function ($join) {
        //         $join->on('quiz_attempts.user_id', '=', 'latest_by_time.user_id')
        //             ->on('quiz_attempts.updated_at', '=', 'latest_by_time.max_updated_at');
        //     })
        //     ->where('quiz_attempts.quiz_id', $this->selectedQuiz->id)
        //     ->whereIn('quiz_attempts.status', ['completed', 'graded'])
        //     ->groupBy('quiz_attempts.user_id');

        // Stats from the same base (single source of truth)
        $statsBase = QuizAttempt::query()
            ->joinSub($latestAttemptPerUser, 'latest_attempts', function ($join) {
                $join->on('quiz_attempts.updated_at', '=', 'latest_attempts.max_updated_at');
            });

        // Single query to get count and average points
        $stats = (clone $statsBase)
            ->selectRaw('COUNT(*) as total_participants, AVG(quiz_attempts.total_score) as avg_points')
            ->first();

        $totalParticipants = (int) ($stats->total_participants ?? 0);
        $avgPoints = (float) ($stats->avg_points ?? 0.0);
        $averageScore = $this->totalQuestions > 0
            ? ($avgPoints / $this->totalQuestions) * 100
            : 0.0;

        // Participants list with relations
        $participantsQuery = QuizAttempt::query()
            ->select('quiz_attempts.*')
            ->joinSub($latestAttemptPerUser, 'latest_attempts', function ($join) {
                $join->on('quiz_attempts.updated_at', '=', 'latest_attempts.max_updated_at');
            })
            ->with(
                $this->activeTab === 'participants'
                    ? [
                        'user:id,first_name,surname,username',
                        'answers:id,quiz_attempt_id,quiz_question_id,is_correct,answer',
                    ]
                    : [
                        'answers:id,quiz_attempt_id,quiz_question_id,is_correct,answer',
                    ]
            )
            ->when($this->search && $this->activeTab === 'participants', function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                        ->orWhere('surname', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('quiz_attempts.total_score', 'desc');

        $participants = $participantsQuery->paginate(10);

        // Only load heavy relations for questions on demand
        if ($this->activeTab === 'questions') {
            $this->selectedQuiz->loadMissing(['questions.choices']);
        }

        return view('livewire.course.published.quiz-report', [
            'participants' => $participants,
            'totalParticipants' => $totalParticipants,
            'averageScore' => $averageScore,
            'totalQuestions' => $this->totalQuestions,
        ]);
    }
}
