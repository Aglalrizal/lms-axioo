<?php

namespace App\Livewire\Quiz;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\QuizAttempt;

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
        $attempt = QuizAttempt::findOrFail($this->attemptId);
        $this->timeLeft = $attempt->time_left;

        if ($this->timeLeft <= 0 && !$attempt->is_finished) {
            $attempt->update(['is_finished' => true]);
            // trigger event untuk auto-submit jawaban
            $this->dispatch('quiz-finished');
        }
    }
    public function render()
    {
        return view('livewire.quiz.timer');
    }
}
