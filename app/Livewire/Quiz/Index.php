<?php

namespace App\Livewire\Quiz;

use App\Models\Course;
use App\Models\Quiz;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    public $courses;
    public $selectedCourse = null;
    public $quizzes;

    public $syllabusId;
    public $courseContentId;
    public $selectedQuiz;
    public $openQuiz = false;

    public $quizToDelete;


    #[On('refresh-list')]
    public function refresh(){
        $this->quizzes = collect();

        foreach ($this->selectedCourse->syllabus as $syl) {
            foreach ($syl->courseContents as $content) {
                if ($content->type == 'quiz' && $content->quiz) {
                    $this->quizzes->push($content->quiz);
                }
            }
        }
    }
    public function mount()
    {
        $this->courses = Course::with('syllabus.courseContents.quiz')->get();
    }

    public function selectCourse($courseId)
    {
        $this->selectedCourse = Course::with('syllabus.courseContents.quiz')->findOrFail($courseId);

        $this->quizzes = collect();

        foreach ($this->selectedCourse->syllabus as $syl) {
            foreach ($syl->courseContents as $content) {
                if ($content->type == 'quiz' && $content->quiz) {
                    $this->quizzes->push($content->quiz);
                }
            }
        }
    }
    public function addNewQuiz(){
        $this->openQuiz = true;
    }
    public function openQuizPage($quizId){
        $this->selectedQuiz = Quiz::with('courseContent.courseSyllabus')->findOrFail($quizId);
        $this->syllabusId = $this->selectedQuiz->courseContent->courseSyllabus->id;
        $this->courseContentId = $this->selectedQuiz->courseContent->id;
        $this->openQuiz = true;
    }
    #[On('close-add-quiz')]
    public function closeQuizPage(){
        $this->openQuiz = false;
        $this->reset(['selectedQuiz','syllabusId', 'courseContentId']);
    }
    public function render()
    {
        return view('livewire.quiz.index');
    }
    #[On('delete-quiz')]
    public function confirmDelete($id)
    {
        $this->quizToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Iya, hapus!')
            ->option('denyButtonText', 'Batal')
            ->option('id', $id) 
            ->warning('Apakah anda yakin ingin menghapus kuis ini?', ['Confirm Deletion']);
    }

    #[On('sweetalert:confirmed')]
    public function delete(array $payload)
    {
        if ($this->quizToDelete) {
            $q = Quiz::with('questions.choices', 'courseContent')->findOrFail($this->quizToDelete);
            if ($q) {
                foreach ($q->questions as $question) {
                    $question->choices()->delete();
                }
                $q->questions()->delete();
                $q->courseContent()->delete();
                $q->delete();
                flash()->success('Kuis berhasil dihapus!');
            } else {
                flash()->error('Kuis tidak ditemukan.');
            }
            $this->quizToDelete = null;
            $this->refresh();
        }
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        if($this->quizToDelete){
            $this->quizToDelete = null;
            flash()->info('Penghapusan kuis dibatalkan.');
        }
    }
}
