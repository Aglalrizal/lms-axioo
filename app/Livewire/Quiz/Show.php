<?php

namespace App\Livewire\Quiz;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.base')]
class Show extends Component
{
    public function render()
    {
        return view('livewire.quiz.show');
    }
}
