<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class CourseSearchByCategory extends Component
{
    public function render()
    {
        return view('livewire.course-search-by-category');
    }
}
