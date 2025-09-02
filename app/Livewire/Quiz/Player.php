<?php

namespace App\Livewire\Quiz;

use App\Models\CourseContent;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;

#[Layout('layouts.base')]
class Player extends Component
{
    public $content, $quiz;
    public $attempt;
    public $questions;
    public $answers = [];

    public function mount($attempt)
    {
        $this->attempt = QuizAttempt::findOrFail($attempt);
        $this->quiz = $this->attempt->quiz;
        $this->content = CourseContent::findOrFail($this->quiz->course_content_id);
        $this->questions = $this->quiz->questions()->with('choices')->get();

        foreach ($this->attempt->answers as $ans) {
            $this->answers[$ans->quiz_question_id] = $ans->answer;
        }
    }

    public function saveAnswer($questionId, $optionId)
    {
        $question = QuizQuestion::with('choices')->findOrFail($questionId);

        $isCorrect = false;
        $score = 0;

        $correctOption = $question->choices()->where('is_correct', true)->first();
        if ($correctOption && $correctOption->id == $optionId) {
            $isCorrect = true;
            $score = $question->score ?? 1;
        }

        QuizAnswer::updateOrCreate(
            [
                'quiz_attempt_id' => $this->attempt->id,
                'quiz_question_id' => $questionId,
            ],
            [
                'answer' => $optionId,
                'is_correct' => $isCorrect,
                'score' => $score,
            ]
        );

        $this->answers[$questionId] = $optionId;
    }

    public function finishQuiz()
    {
        $totalScore = $this->attempt->answers()->sum('score');
        $this->attempt->update([
            'status' => 'graded',
            'total_score' => $totalScore,
        ]);

        dd($totalScore);
        //return redirect()->route('quiz.result', $this->attempt->id);
    }

    public function render(){
        return view('livewire.quiz.player');
    }

}
