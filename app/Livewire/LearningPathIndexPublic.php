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
        $learningPaths = LearningPath::query()
            ->where('is_published', true)
            ->select('id', 'title', 'slug', 'description')
            ->withCount('steps')
            ->latest()
            ->paginate(12);

        return view('livewire.learning-path-index-public', [
            'learningPaths' => $learningPaths
        ]);
    }
}
