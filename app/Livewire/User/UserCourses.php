<?php

namespace App\Livewire\User;

use App\Models\CourseProgress;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.dashboard')]

class UserCourses extends Component
{
    public $isShowing = 'onGoing';

    public function setShow($showing): void
    {
        $this->isShowing = $showing;
    }

    public function render()
    {
        $baseQuery = Auth::user()
            ->enrolledCourses()
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
                    ->take(1)
            ]);

        if ($this->isShowing === 'completed') {
            // Only courses with 100% completion
            $baseQuery->havingRaw('completed_contents = total_contents');
        } else {
            // Only courses with less than 100% completion
            $baseQuery->havingRaw('completed_contents < total_contents OR total_contents = 0');
        }

        $courses = $baseQuery
            ->orderBy('last_progress', 'desc')
            ->get()
            ->map(function ($course) {
                $course->progress_percentage = $course->total_contents > 0
                    ? round(($course->completed_contents / $course->total_contents) * 100)
                    : 0;
                return $course;
            });

        return view('livewire.user-courses', [
            'courses' => $courses,
        ]);
    }
}
