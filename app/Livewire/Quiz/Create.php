<?php

namespace App\Livewire\Quiz;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\QuizQuestion;
use Livewire\WithPagination;
use App\Models\CourseContent;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.dashboard')]
class Create extends Component
{
    use WithPagination;
    public $syllabusId;
    public $search = '';
    public $filterType = '';
    public $sortBy = 'order';
    public $sortDirection = 'asc';
    public $courseContentId;
    public $quiz;
    #[Rule('required')]
    public $title;
    #[Rule('required')]
    public $duration;
    #[Rule('required')]
    public $number_of_questions;
    #[Rule('required')]
    public $content;  
    public $courseContent;  
    public $showForm = true;
    public $showQuizInfo = false;
    public $quizId;

    public $courseId;
    public $questionToDelete;
    
    public function toogleQuizForm(){
        $this->showForm = !$this->showForm;
    }
    public function mount($courseContentId = null)
    {
        
        if ($courseContentId) {
            $this->courseContentId = $courseContentId;
            $this->courseContent = CourseContent::with('quiz.questions')->findOrFail($courseContentId);
            $this->quiz = $this->courseContent->quiz;
            $this->title = $this->courseContent->title;
            $this->content = $this->courseContent->content;
            $this->duration = $this->quiz->duration ?? null;
            $this->number_of_questions = $this->quiz->number_of_questions ?? null;
            $this->toogleQuizForm();
        }
    }

    #[On('refresh-questions')]
    public function refreshQuestions(){}

    public function render()
    {
        $questions = QuizQuestion::with('choices')
            ->where('quiz_id', $this->quiz?->id)
                    ->when($this->filterType, function ($query) {
            $query->where('question_type', $this->filterType);
            })
            ->when($this->search, function ($query) {
                $query->where('question', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(5);

        return view('livewire.quiz.create', [
            'questions' => $questions,
        ]);
    }
    public function saveQuiz()
    {
        $data = $this->validate();

        if ($this->courseContentId) {
            $this->courseContent = CourseContent::findOrFail($this->courseContentId);
            $this->courseContent->update([
                'title' => $data['title'],
                'content' => $data['content'],
                'modified_by' => Auth::user()->username,
            ]);
            if($this->courseContent->course_syllabus_id != $this->syllabusId){
                $lastOrder = CourseContent::where('course_syllabus_id', $this->syllabusId)->max('order') ?? 0;
                $data['order'] = $lastOrder + 1;
                $this->courseContent->update([
                    'course_syllabus_id' => $this->syllabusId,
                    'order' => $data['order'] 
                ]);
            }
            if ($this->courseContent->quiz) {
                $this->courseContent->quiz->update([
                    'title' => $data['title'],
                    'duration' => $data['duration'],
                    'number_of_questions' => $data['number_of_questions'],
                    'modified_by' => Auth::user()->username,
                ]);
            } else {
                $this->quiz = $this->courseContent->quiz()->create([
                    'title' => $data['title'],
                    'duration' => $data['duration'],
                    'number_of_questions' => $data['number_of_questions'],
                    'created_by' => Auth::user()->username,
                    'modified_by' => Auth::user()->username,
                ]);
                $this->courseContent->update([
                    'quiz_id' => $this->quiz->id,
                ]);
            }
            $this->courseContent->refresh();
            $this->quiz = $this->courseContent->quiz;
            flash()->success('Kuis berhasil diperbarui!', [], 'Sukses');
        } else {
            $lastOrder = CourseContent::where('course_syllabus_id', $this->syllabusId)->max('order') ?? 0;
            $data['order'] = $lastOrder + 1;

            $this->courseContent = CourseContent::create([
                'course_syllabus_id' => $this->syllabusId,
                'title' => $data['title'],
                'is_assessment' => true,
                'is_free_preview' => false,
                'order' => $data['order'],
                'content' => $data['content'],
                'created_by' => Auth::user()->username,
                'modified_by' => Auth::user()->username,
            ]);

            $this->quiz = $this->courseContent->quiz()->create([
                'title' => $data['title'],
                'duration' => $data['duration'],
                'number_of_questions' => $data['number_of_questions'],
                'created_by' => Auth::user()->username,
                'modified_by' => Auth::user()->username,
            ]);

            $this->courseContent->update([
                'quiz_id' => $this->quiz->id,
            ]);
            flash()->success('Kuis berhasil disimpan!', [], 'Sukses');
        }
        $this->dispatch('refresh-list');
        $this->toogleQuizForm();
    }
    public function back(){
        $this->dispatch('close-add-quiz');
    }
    #[On('delete-question')]
    public function confirmDelete($id)
    {
        $this->questionToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Iya, hapus!')
            ->option('denyButtonText', 'Batal')
            ->option('id', $id)
            ->warning('Apakah kamu yakin ingin menghapus pertanyaan ini?', ['Confirm Deletion']);
    }

    #[On('sweetalert:confirmed')]
    public function delete(array $payload)
    {
        $question = QuizQuestion::find($this->questionToDelete);
        if ($question) {
            $question->delete();
            flash()->success('Berhasil menghapus pertanyaan!', [], 'Sukses');
        } else {
            flash()->error('Pertanyaan tidak ditemukan.');
        }

        $this->questionToDelete = null;
        $this->refreshQuestions();
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        $this->questionToDelete = null;
        flash()->info('Penghapusan pertanyaan dibatalkan.', [], 'Informasi');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
