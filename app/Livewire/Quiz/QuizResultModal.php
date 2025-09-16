<?php

namespace App\Livewire\Quiz;

use App\Models\QuizAttempt;
use Livewire\Component;

class QuizResultModal extends Component
{
    public $attemptId;

    public $quizAttempt;

    public function updatedAttemptId($value)
    {
        $this->loadAttempt();
    }

    public function loadAttempt()
    {
        if ($this->attemptId) {
            $this->quizAttempt = QuizAttempt::with([
                'quiz.questions.choices',
                'answers',
            ])->find($this->attemptId);
        }
    }

    public function mount()
    {
        if ($this->attemptId) {
            $this->quizAttempt = QuizAttempt::with([
                'quiz.questions.choices',
                'answers',
            ])->find($this->attemptId);
        }
    }

    public function render()
    {
        return view('livewire.quiz.quiz-result-modal');
    }
}
