<?php

namespace App\Livewire\Instructor;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.instructor.dashboard');
    }
}
