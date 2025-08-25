<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Program;
use Livewire\Component;
use App\Enums\AccessType;
use App\Enums\CourseLevel;
use App\Models\CourseCategory;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]

class CourseSearch extends Component
{
    public $search = '';
    public $selectedProgram = '';
    public $selectedAccessType = '';
    public $selectedCategory = '';
    public $selectedLevel = '';

    public function render()
    {
        $query = Course::where('is_published', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedProgram) {
            $query->where('program_id', $this->selectedProgram);
        }

        if ($this->selectedAccessType) {
            $query->where('access_type', $this->selectedAccessType);
        }

        if ($this->selectedCategory) {
            $query->where('course_category_id', $this->selectedCategory);
        }

        if ($this->selectedLevel) {
            $query->where('level', $this->selectedLevel);
        }

        $courses = $query
            ->limit(6)
            ->get();

        return view('livewire.course-search', [
            'programs' => Program::all(),
            'categories' => CourseCategory::all(),
            'accessTypes' => AccessType::toArray(),
            'courseLevels' => CourseLevel::toArray(),
            'courses' => $courses
        ]);
    }
}
