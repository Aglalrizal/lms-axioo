<?php

namespace App\Livewire\Quiz;

use Livewire\Component;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Livewire\Attributes\On;
use App\Models\QuizQuestion;
use App\Models\CourseContent;
use App\Models\CourseProgress;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

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
        if ($this->attempt->user_id !== Auth::id()) {
            return abort(403);;
        }
        $this->quiz = $this->attempt->quiz;
        $this->content = CourseContent::findOrFail($this->quiz->course_content_id);
        $this->questions = $this->quiz->questions()->with('choices')->get();

        foreach ($this->attempt->answers as $ans) {
            $this->answers[$ans->quiz_question_id] = $ans->answer;
        }
        if ($this->attempt->time_left <= 0) {
            $attempt = QuizAttempt::findOrFail($this->attempt->id);
            if ($attempt->status !== 'graded') {
                $attempt->update(['status' => 'graded']);
            }
            $this->quizEnded();
        }
        if($this->attempt->status === 'graded'){
            $this->quizEnded();
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
        if($this->attempt->percentage >= 75 ){
            CourseProgress::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'course_id' => $this->content->course->id,
                'course_content_id' => $this->content->id,
            ],
            [
                'is_completed' => true,
            ]
        );
        }
        flash()->success('Jawaban berhasil disimpan', [], 'Sukses');
        return redirect(route('course.show.content', [
            'slug' => $this->quiz->courseContent->course->slug,
            'syllabusId' => $this->quiz->courseContent->courseSyllabus->id,
            'courseContentId' => $this->quiz->courseContent->id
        ]));
    }

    #[On('quiz-finished')]
    public function quizEnded(){
        flash()->info('Kuis telah selesai', [], 'Informasi');
        return redirect(route('course.show.content', [
            'slug' => $this->quiz->courseContent->course->slug,
            'syllabusId' => $this->quiz->courseContent->courseSyllabus->id,
            'courseContentId' => $this->quiz->courseContent->id
        ]));
    }

    public function render(){
        return view('livewire.quiz.show');
    }

}
