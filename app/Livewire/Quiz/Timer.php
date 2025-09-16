<?php

namespace App\Livewire\Quiz;

use App\Models\QuizAttempt;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.base')]
class Timer extends Component
{
    public $attemptId;

    public $timeLeft;

    protected $listeners = ['tick' => 'updateTimer'];

    public function mount($attemptId)
    {
        $this->attemptId = $attemptId;
        $attempt = QuizAttempt::findOrFail($attemptId);

        $this->timeLeft = $attempt->time_left;
    }

    public function updateTimer()
    {
        $this->timeLeft--;

        if ($this->timeLeft <= 0) {
            $attempt = QuizAttempt::findOrFail($this->attemptId);
            if ($attempt->status !== 'graded') {
                $attempt->update(['status' => 'graded']);
            }
            $this->dispatch('quiz-finished');
        }
    }

    public function render()
    {
        return view('livewire.quiz.timer');
    }
}
