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
        // Query courses dengan filter dan search
        $courses = Course::with(['teacher', 'courseCategory', 'program'])
            ->where('is_published', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('short_desc', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedProgram, function ($query) {
                $query->where('program_id', $this->selectedProgram);
            })
            ->when($this->selectedAccessType, function ($query) {
                $query->where('access_type', $this->selectedAccessType);
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('course_category_id', $this->selectedCategory);
            })
            ->when($this->selectedLevel, function ($query) {
                $query->where('level', $this->selectedLevel);
            })
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
