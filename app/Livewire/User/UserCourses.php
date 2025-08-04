<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.authenticated.dashboard')]

class UserCourses extends Component
{

    public $isShowing = 'onGoing';

    public function setShow($showing): void
    {
        $this->isShowing = $showing;
    }

    public function render()
    {
        return view('livewire.user-courses', [
            'courses' => [] // Assuming you will fetch the courses from a model or service,
        ]);
    }
}
