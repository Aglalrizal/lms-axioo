<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class Landing extends Component
{
    public function render()
    {
        return view('livewire.landing', [
            'courses' => Course::query()
                ->where('is_published', true)
                ->select('id', 'title', 'thumbnail', 'level', 'access_type', 'program_id', 'course_category_id', 'short_desc', 'slug')
                ->with([
                    'program:id,name',
                    'courseCategory:id,name'
                ])
                ->limit(4)
                ->get()
        ]);
    }
}
