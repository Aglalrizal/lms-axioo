<?php

namespace App\Livewire\Course\Published;

use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    public $courses;
    public function mount(){
        $this->courses = Course::where('is_published', true)->with('syllabus.courseContents.quiz')->get();
    }
    public function render()
    {
        return view('livewire.course.published.index');
    }
}
