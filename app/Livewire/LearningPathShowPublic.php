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
        $this->path = LearningPath::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->select('id', 'title', 'description')
            ->with(['steps.course:id,title,slug'])
            ->withCount('steps')
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.learning-path-show-public');
    }
}
