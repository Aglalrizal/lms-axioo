<?php

namespace App\Livewire;

use App\Models\LearningPath;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class LearningPathShowPublic extends Component
{
    public LearningPath $path;

    public function mount($slug)
    {
        $this->path = LearningPath::with(['steps.course'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.learning-path-show-public');
    }
}
