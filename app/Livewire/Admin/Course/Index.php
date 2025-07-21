<?php

namespace App\Livewire\Admin\Course;

use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]

class Index extends Component
{
    public $courses;
    public function mount(){
        $this->courses = Course::with(['teacher', 'syllabus.contents'])->latest()->get();
    }
    public function render()
    {
        return view('livewire.admin.course.index');
    }
}
