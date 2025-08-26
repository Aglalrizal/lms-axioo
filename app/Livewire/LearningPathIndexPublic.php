<?php

namespace App\Livewire;

use App\Models\LearningPath;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class LearningPathIndexPublic extends Component
{
    use WithPagination;

    public function render()
    {
        $learningPaths = LearningPath::where('is_published', true)
            ->latest()
            ->paginate(12);

        // with(['steps.course'])

        return view('livewire.learning-path-index-public', [
            'learningPaths' => $learningPaths
        ]);
    }
}
