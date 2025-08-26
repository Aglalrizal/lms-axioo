<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Program;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]

class CourseExplore extends Component
{
    public function render()
    {
        return view(
            'livewire.course-explore',
            [
                'programs' => Program::all(),
                'courses' => Course::all(),
            ]
        );
    }
}
