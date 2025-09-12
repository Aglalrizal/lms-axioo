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
            ->courseProgressInformation();

        if ($this->isShowing === 'completed') {
            // Only courses with 100% completion
            $baseQuery->havingRaw('completed_contents = total_contents');
        } else {
            // Only courses with less than 100% completion
            $baseQuery->havingRaw('completed_contents < total_contents OR total_contents = 0');
        }

        $courses = $baseQuery
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
