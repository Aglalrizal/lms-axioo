<?php

namespace App\Livewire\Instructor\Course;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    public $selectedCourse;

    public $search = '';

    public $filterType = '';

    public $sortBy = 'title';

    public $sortDirection = 'asc';

    public function selectCourse($courseId)
    {
        $this->selectedCourse = Course::with('syllabus.contents.quiz')->findOrFail($courseId);
    }

    public function render()
    {
        $courses = Course::where('teacher_id', Auth::user()->id)->with(['courseCategory', 'teacher', 'syllabus.contents.quiz'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->when($this->filterType, function ($query) {
                $query->where('access_type', $this->filterType);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(5);

        return view('livewire.instructor.course.index', compact('courses'));
    }
}
