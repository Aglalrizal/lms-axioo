<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Program;
use Livewire\Component;
use App\Enums\AccessType;
use App\Enums\CourseLevel;
use App\Models\CourseCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use function Laravel\Prompts\select;

#[Layout('layouts.app')]

class CourseSearch extends Component
{
    #[Url]
    public $search, $program, $accessType, $category, $level;

    public function render()
    {
        $query = Course::where('is_published', true);

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->program) {
            $query->whereHas('program', fn($q) => $q->where('slug', $this->program));
        }

        if ($this->accessType) {
            $query->where('access_type', $this->accessType);
        }

        if ($this->category) {
            $query->whereHas('courseCategory', fn($q) => $q->where('slug', $this->category));
        }

        if ($this->level) {
            $query->where('level', $this->level);
        }

        $courses = $query
            ->with(['program', 'courseCategory'])
            ->limit(6)
            ->get();

        return view('livewire.course-search', [
            'programs' => Program::select('id', 'name', 'slug')->get(),
            'categories' => CourseCategory::select('id', 'name', 'slug')->get(),
            'accessTypes' => AccessType::toArray(),
            'courseLevels' => CourseLevel::toArray(),
            'courses' => $courses
        ]);
    }
}
