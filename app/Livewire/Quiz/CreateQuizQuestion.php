<?php

namespace App\Livewire\Quiz;

use App\Models\Quiz;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\QuizChoice;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Auth;

class CreateQuizQuestion extends Component
{
    public $quizId;
    public $questionText;
    public $question;
    public $formtitle = 'Tambah Pertanyaan';
    public $editform = false;
    public $question_type = 'multiple_choice';
    public $choices = [];
    public ?int $correctIndex = 0;

    public function mount()
    {
        $this->initializeChoices();
    }

    public function render()
    {
        return view('livewire.quiz.create-quiz-question');
    }

    public function updatedQuestionType($value)
    {
        if ($value === 'multiple_choice') {
            $this->initializeChoices();
        } elseif ($value === 'short_answer') {
            $this->choices = [];
            $this->correctIndex = null;
        }
    }

    private function initializeChoices()
    {
        $this->choices = [
            ['text' => ''],
            ['text' => ''],
            ['text' => ''],
            ['text' => ''],
        ];
        $this->correctIndex = 0;
    }

    public function addChoice()
    {
        $this->choices[] = ['text' => ''];
    }

    public function removeChoice($index)
    {
        unset($this->choices[$index]);
        $this->choices = array_values($this->choices);
    }

    #[On('reset-quiz-question-modal')]
    public function resetModal()
    {
        $this->reset([
            'questionText', 'choices', 'correctIndex',
            'question_type', 'editform', 'formtitle', 'question'
        ]);
        $this->question_type = 'multiple_choice';
        $this->initializeChoices();
    }

    public function saveQuestion()
    {
        $lastOrder = QuizQuestion::where('quiz_id', $this->quizId)->max('order') ?? 0;
        $question = QuizQuestion::create([
            'quiz_id' => $this->quizId,
            'question' => $this->questionText,
            'question_type' => $this->question_type,
            'score' => 1,
            'order' => $lastOrder + 1,
            'created_by' => Auth::user()->username,
            'modified_by' => Auth::user()->username,
        ]);

        if ($this->question_type === 'multiple_choice') {
            foreach ($this->choices as $index => $choice) {
                QuizChoice::create([
                    'question_id' => $question->id,
                    'answer_option' => $choice['text'],
                    'is_correct' => $this->correctIndex === $index,
                    'created_by' => Auth::user()->username,
                    'modified_by' => Auth::user()->username,
                ]);
            }
        }

        $this->resetModal();
        flash()->success('Pertanyaan berhasil disimpan', [], 'Sukses');
        $this->dispatch('refresh-questions');
    }

    #[On('edit-question-mode')]
    public function edit($id)
    {
        $this->editform = true;
        $this->formtitle = 'Edit Pertanyaan';
        $this->question = QuizQuestion::with('choices')->findOrFail($id);
        $this->questionText = $this->question->question;
        $this->question_type = $this->question->question_type;

        if ($this->question_type === 'multiple_choice') {
            $this->choices = $this->question->choices->map(fn($choice) => [
                'id' => $choice->id,
                'text' => $choice->answer_option,
                'is_correct' => $choice->is_correct,
            ])->toArray();

            $this->correctIndex = collect($this->choices)->search(fn($c) => $c['is_correct'] === true);
        } else {
            $this->choices = [];
            $this->correctIndex = null;
        }
    }

    public function update()
    {
        $this->question->update([
            'question' => $this->questionText,
            'question_type' => $this->question_type,
            'score' => 1,
            'modified_by' => Auth::user()->username,
        ]);

        $this->question->choices()->delete();

        if ($this->question_type === 'multiple_choice') {
            foreach ($this->choices as $index => $choice) {
                QuizChoice::updateOrCreate(
                    ['id' => $choice['id'] ?? null],
                    [
                        'question_id' => $this->question->id,
                        'answer_option' => $choice['text'],
                        'is_correct' => $this->correctIndex === $index,
                        'modified_by' => Auth::user()->username,
                        'created_by' => Auth::user()->username,
                    ]
                );
            }
        }

        flash()->success('Berhasil memperbarui pertanyaan!');
        $this->dispatch('refresh-questions');
        $this->resetModal();
    }
}
