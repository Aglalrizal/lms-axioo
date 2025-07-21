<?php

namespace App\Livewire\Admin\Course\Steps;

use App\Models\Course;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('layouts.dashboard')]
class StepFour extends Component
{
    public $step = 4;
    public $slug;
    #[Rule('required')]
    public $extra_description;
    public $is_published = false;
    public $course;

    public function mount(){
        $this->course = Course::where('slug', $this->slug)->first();
        $this->extra_description = $this->course->extra_description;
        $this->dispatch('update-jodit-content', $this->course->extra_description);
    }

    public function save(){
        $data = $this->validate();
        $this->course = Course::where('slug', $this->slug)->first();
        $this->course->update($data);
        flash()->success('Berhasil menyimpan data!');
    }
    public function render()
    {
        return view('livewire.admin.course.steps.step-four');
    }
}
