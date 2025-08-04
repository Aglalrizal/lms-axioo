<?php

namespace App\Livewire\Admin\Course;

use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    public $search = '';
    public $filterType = '';
    public $sortBy = 'title';
    public $sortDirection = 'asc';

    public function render()
    {
        $courses = Course::with(['courseCategory','teacher', 'syllabus.contents'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterType, function ($query) {
                $query->where('course_type', $this->filterType); 
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();

        return view('livewire.admin.course.index', [
            'courses' => $courses
        ]);
    }
}
