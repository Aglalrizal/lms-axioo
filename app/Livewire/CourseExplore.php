<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Program;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class CourseExplore extends Component
{
    public function render()
    {
        return view(
            'livewire.course-explore',
            [
                'programs' => Program::query()
                    ->select('id', 'name', 'slug', 'image_path')
                    ->withCount('courses')
                    ->get(),
                'courses' => Course::query()
                    ->where('is_published', true)
                    ->select('id', 'title', 'thumbnail', 'level', 'access_type', 'program_id', 'course_category_id', 'short_desc', 'slug', 'duration')
                    ->with([
                        'program:id,name',
                        'courseCategory:id,name',
                    ])
                    ->limit(4)
                    ->get(),
            ]
        );
    }
}
