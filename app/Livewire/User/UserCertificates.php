<?php

namespace App\Livewire\User;

use App\Models\CourseProgress;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]

class UserCertificates extends Component
{
    public function render()
    {
        $completedCourses = Auth::user()
            ->enrolledCourses()
            ->withCount('contents as total_contents')
            ->withCount(['progresses as completed_contents' => function ($query) {
                $query->where('student_id', Auth::id());
                $query->where('is_completed', true);
            }])
            ->addSelect([
                'last_progress' => CourseProgress::query()->select('updated_at')
                    ->whereColumn('course_id', 'courses.id')
                    ->where('student_id', Auth::id())
                    ->latest('updated_at')
                    ->take(1),
            ])
            ->withCasts(['last_progress' => 'datetime'])
            ->with('courseCategory:id,name')
            ->havingRaw('completed_contents = total_contents')
            ->orderBy('last_progress', 'desc')
            ->paginate(6);

        return view('livewire.user-certificates', [
            'completedCourses' => $completedCourses,
        ]);
    }
}
