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
            'courses' => Course::where('is_published', true)->limit(4)->get()
        ]);
    }
}
