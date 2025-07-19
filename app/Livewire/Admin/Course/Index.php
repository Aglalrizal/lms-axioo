<?php

namespace App\Livewire\Admin\Course;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.course.index');
    }
}
