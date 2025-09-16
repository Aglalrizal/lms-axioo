<?php

namespace App\Livewire\Admin\Course;

use App\Models\Course;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class CreateCourse extends Component
{
    public $step = 1;

    public $slug;

    public $course;

    protected $queryString = [
        'step' => ['except' => 1],
    ];

    #[On('next')]
    public function next()
    {
        $this->step++;
    }

    #[On('back')]
    public function back()
    {
        $this->step--;
    }

    #[On('set-course')]
    public function setCourse($slug)
    {
        $this->course = Course::where('slug', $slug)->firstOrFail();
    }

    public function mount($slug = null)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.admin.course.create-course');
    }
}
