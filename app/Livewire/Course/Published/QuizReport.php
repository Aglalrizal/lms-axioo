<?php

namespace App\Livewire\Course\Published;

use App\Models\Quiz;
use App\Models\Course;
use Livewire\Component;
use App\Models\QuizAttempt;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class QuizReport extends Component
{
    use WithPagination;

    public $course;
    public $slug;
    public $quiz_id = null;
    public $selectedQuiz = null;
    public $search = '';
    public $activeTab = 'participants';
    protected $updatesQueryString = ['activeTab', 'search', 'quiz_id'];

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
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

        // Get quiz_id from query parameter
        $this->quiz_id = request('quiz_id');

        // If quiz_id is provided, load the specific quiz
        if ($this->quiz_id) {
            $this->selectedQuiz = Quiz::with(['courseContent', 'questions.choices'])
                ->whereHas('courseContent.courseSyllabus', function ($query) {
                    $query->where('course_id', $this->course->id);
                })
                ->findOrFail($this->quiz_id);
        }
    }

    public function render()
    {
        $participants = collect();

        // Only get participants if specific quiz is selected
        if ($this->selectedQuiz) {
            // Get the latest attempt for each user
            $latestAttempts = QuizAttempt::query()
                ->selectRaw('MAX(id) as latest_attempt_id')
                ->where('quiz_id', $this->selectedQuiz->id)
                ->whereIn('status', ['completed', 'graded'])
                ->groupBy('user_id')
                ->pluck('latest_attempt_id');

            $participants = QuizAttempt::query()
                ->whereIn('id', $latestAttempts)
                ->with([
                    'user',
                    'quiz.courseContent',
                    'answers.quizQuestion'
                ])
                ->when($this->search && $this->activeTab === 'participants', function ($query) {
                    $query->whereHas('user', function ($q) {
                        $q->where('first_name', 'like', '%' . $this->search . '%')
                            ->orWhere('surname', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy('total_score', 'desc')
                ->paginate(10);
        }

        return view('livewire.course.published.quiz-report', [
            'participants' => $participants,
        ]);
    }
}
