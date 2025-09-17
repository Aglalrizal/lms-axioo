<?php

namespace App\Livewire\Course\Published;

use App\Models\QuizAttempt;
use Livewire\Attributes\On;
use Livewire\Component;

class QuizAttemptReportModal extends Component
{
    /**
     * Public state consumed by the modal view.
     */
    public ?array $attempt = null;

    public function render()
    {
        return view('livewire.course.published.quiz-attempt-report-modal');
    }

    /**
     * Listen to event from parent to load and show an attempt.
     */
    #[On('show-quiz-attempt')]
    public function showAttempt(int $attemptId): void
    {
        $attempt = QuizAttempt::query()
            ->with([
                'user:id,first_name,surname,username,profile_picture_path',
                'quiz:id',
                'quiz.questions:id,quiz_id,question,question_type,score',
                'answers:id,quiz_attempt_id,quiz_question_id,answer,is_correct,score',
                'answers.quizQuestion:id,quiz_id,question,question_type,score',
                'answers.quizQuestion.choices:id,question_id,answer_option,is_correct',
            ])
            ->findOrFail($attemptId);

        $totalQuestions = $attempt->quiz->questions->count();
        $correct = $attempt->answers->where('is_correct', true)->count();
        $percentage = $totalQuestions > 0
            ? round(($attempt->total_score / $totalQuestions) * 100)
            : 0;

        $answers = [];
        foreach ($attempt->answers as $ans) {
            $q = $ans->quizQuestion;
            if (! $q) {
                continue;
            }
            $choices = [];
            foreach ($q->choices as $choice) {
                $choices[] = [
                    'id' => $choice->id,
                    'text' => $choice->answer_option,
                    'is_correct' => (bool) $choice->is_correct,
                    'is_selected' => (string) $ans->answer === (string) $choice->id,
                ];
            }

            $answers[] = [
                'question_id' => $q->id,
                'question' => $q->question,
                'type' => $q->question_type,
                'score' => $q->score,
                'is_correct' => (bool) $ans->is_correct,
                'selected_answer' => $ans->answer,
                'choices' => $choices,
            ];
        }

        $this->attempt = [
            'id' => $attempt->id,
            'user' => [
                'first_name' => $attempt->user->first_name ?? '',
                'surname' => $attempt->user->surname ?? '',
                'username' => $attempt->user->username ?? '',
                'avatar_url' => $attempt->user->avatar_url ?? null,
            ],
            'end_time' => optional($attempt->end_time)->format('d M Y H:i'),
            'total_score' => (int) $attempt->total_score,
            'percentage' => $percentage,
            'correct' => $correct,
            'total_questions' => $totalQuestions,
            'answers' => $answers,
        ];

        // Tell the browser to show the Bootstrap modal
        $this->dispatch('show-quiz-attempt-modal');
    }
}
