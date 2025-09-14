<?php

namespace App\Livewire\Course\Published;

use App\Models\Quiz;
use App\Models\Course;
use Livewire\Component;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\CourseProgress;
use Livewire\Attributes\Layout;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;

#[Layout('layouts.dashboard')]
class Show extends Component
{
    use WithPagination;
    public Course $course;
    public ?string $slug = null;

    // Separate search states for each tab (no URL binding to avoid collisions)
    public string $searchEnrolled = '';
    public string $searchQuiz = '';
    public string $searchAssignment = '';

    #[Url]
    public string $activeTab = 'description';

    // Cached total contents for the course (used as progress denominator)
    public int $totalContents = 0;

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        // Reset both paginators when switching tab
        $this->resetPage('enrolledPage');
        $this->resetPage('quizzesPage');
        $this->resetPage('assignmentsPage');
    }
    public function updatingSearchEnrolled()
    {
        $this->resetPage('enrolledPage');
    }
    public function updatingSearchQuiz()
    {
        $this->resetPage('quizzesPage');
    }
    public function updatingSearchAssignment()
    {
        $this->resetPage('assignmentsPage');
    }

    #[On('refresh-course')]
    public function refresh()
    {
        $this->course = Course::where('slug', $this->slug)
            ->with(['teacher', 'syllabus.courseContents'])
            ->firstOrFail();
        $this->totalContents = $this->course->contents()->count();
    }

    public function mount($slug = null)
    {
        $this->slug = $slug;
        $this->course = Course::where('slug', $slug)
            ->with(['teacher', 'syllabus.courseContents'])
            ->firstOrFail();
        $this->totalContents = $this->course->contents()->count();
    }

    public function render()
    {
        // Only query data needed for the active tab
        $enrolledStudents = $this->activeTab === 'enrolled'
            ? $this->getEnrolledStudents()
            : $this->emptyPaginator(pageName: 'enrolledPage');

        $quizzes = $this->activeTab === 'quiz'
            ? $this->getQuizzesWithStats()
            : $this->emptyPaginator(pageName: 'quizzesPage');

        $assignments = $this->activeTab === 'assignment'
            ? $this->getAssignmentsWithStats()
            : $this->emptyPaginator(pageName: 'assignmentsPage');

        return view('livewire.course.published.show', [
            'enrolledStudents' => $enrolledStudents,
            'totalContents' => $this->totalContents,
            'quizzes' => $quizzes,
            'assignments' => $assignments,
        ]);
    }

    /**
     * Returns an empty paginator to satisfy the view when the tab is inactive.
     */
    private function emptyPaginator(int $perPage = 10, string $pageName = 'page'): LengthAwarePaginator
    {
        $paginator = new LengthAwarePaginator(
            items: [],
            total: 0,
            perPage: $perPage,
            currentPage: 1,
            options: [
                'path' => request()->url(),
                'pageName' => $pageName,
                'query' => request()->query(),
            ]
        );
        // Align the page name to avoid conflicts when rendering links
        $paginator->setPageName($pageName);
        return $paginator;
    }

    /**
     * Build the enrolled students list with completed content counts.
     */
    private function getEnrolledStudents()
    {
        return Enrollment::with('student')
            ->where('course_id', $this->course->id)
            ->when($this->searchEnrolled, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->searchEnrolled . '%')
                        ->orWhere('surname', 'like', '%' . $this->searchEnrolled . '%');
                });
            })
            ->select('enrollments.*')
            ->addSelect([
                'completed_contents' => CourseProgress::query()
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('course_id', 'enrollments.course_id')
                    ->whereColumn('student_id', 'enrollments.student_id')
                    ->where('is_completed', true),
            ])
            ->orderBy('enrolled_at', 'desc')
            ->paginate(10, ['*'], 'enrolledPage');
    }

    /**
     * Load quizzes for this course with participants_count and average_percentage (latest attempt per user).
     */
    private function getQuizzesWithStats()
    {
        $quizzes = Quiz::query()
            ->whereHas('courseContent', function ($query) {
                $query->whereHas('courseSyllabus', function ($syllabusQuery) {
                    $syllabusQuery->where('course_id', $this->course->id);
                })->where('type', 'quiz');
            })
            ->when($this->searchQuiz, function ($q) {
                $q->whereHas('courseContent', function ($c) {
                    $c->where('title', 'like', '%' . $this->searchQuiz . '%');
                });
            })
            ->with([
                'courseContent:id,title',
            ])
            ->withCount('questions')
            ->paginate(10, ['*'], 'quizzesPage');

        $quizCollection = $quizzes->getCollection();
        $quizIds = $quizCollection->pluck('id');

        $participantsPerQuiz = QuizAttempt::query()
            ->selectRaw('quiz_id, COUNT(DISTINCT user_id) as participants')
            ->whereIn('quiz_id', $quizIds)
            ->whereIn('status', ['completed', 'graded'])
            ->groupBy('quiz_id')
            ->pluck('participants', 'quiz_id');

        $latestAttemptPerUser = QuizAttempt::query()
            ->selectRaw('quiz_id, user_id, MAX(updated_at) as max_updated_at')
            ->whereIn('quiz_id', $quizIds)
            ->whereIn('status', ['completed', 'graded'])
            ->groupBy('quiz_id', 'user_id');

        $sumPointsPerQuiz = QuizAttempt::query()
            ->joinSub($latestAttemptPerUser, 'latest_attempts', function ($join) {
                $join->on('quiz_attempts.quiz_id', '=', 'latest_attempts.quiz_id')
                    ->on('quiz_attempts.user_id', '=', 'latest_attempts.user_id')
                    ->on('quiz_attempts.updated_at', '=', 'latest_attempts.max_updated_at');
            })
            ->selectRaw('quiz_attempts.quiz_id, SUM(quiz_attempts.total_score) as sum_points')
            ->groupBy('quiz_attempts.quiz_id')
            ->pluck('sum_points', 'quiz_id');

        $quizCollection->transform(function (Quiz $quiz) use ($participantsPerQuiz, $sumPointsPerQuiz) {
            $participants = (int) ($participantsPerQuiz[$quiz->id] ?? 0);
            $quiz->participants_count = $participants;
            $questionCount = (int) ($quiz->questions_count ?? 0);
            $sumPoints = (float) ($sumPointsPerQuiz[$quiz->id] ?? 0);
            $quiz->average_percentage = ($questionCount > 0 && $participants > 0)
                ? round((($sumPoints / $participants) / $questionCount) * 100, 1)
                : 0.0;
            return $quiz;
        });

        return $quizzes;
    }

    /**
     * Load assignments with distinct submitter counts per assignment.
     */
    private function getAssignmentsWithStats(): LengthAwarePaginator
    {
        $assignments = Assignment::query()
            ->whereHas('courseContent', function ($query) {
                $query->whereHas('courseSyllabus', function ($syllabusQuery) {
                    $syllabusQuery->where('course_id', $this->course->id);
                })->where('type', 'assignment');
            })
            ->when($this->searchAssignment, function ($q) {
                $q->whereHas('courseContent', function ($c) {
                    $c->where('title', 'like', '%' . $this->searchAssignment . '%');
                });
            })
            ->with(['courseContent:id,title'])
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'assignmentsPage');

        $assignmentIds = $assignments->pluck('id');

        $submissionCounts = AssignmentSubmission::query()
            ->selectRaw('assignment_id, COUNT(DISTINCT student_id) as submitters')
            ->whereIn('assignment_id', $assignmentIds)
            ->groupBy('assignment_id')
            ->pluck('submitters', 'assignment_id');

        $assignments->getCollection()->transform(function (Assignment $assignment) use ($submissionCounts) {
            $assignment->submitters_count = (int) ($submissionCounts[$assignment->id] ?? 0);
            return $assignment;
        });

        return $assignments;
    }
}
