<?php

namespace App\Livewire\Course\Public;

use App\Models\Course;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CourseProgress;
use Livewire\Attributes\Layout;
use App\Models\AssignmentSubmission;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

#[Layout('layouts.courseContent')]
class ShowContent extends Component
{
    use WithPagination;
    public $content;
    public $course;
    public $currentSyllabus;
    public $prevContent, $nextContent;
    public $file, $url, $textAnswer;
    public $submission;
    protected $rules = [
        'textAnswer' => 'nullable|string',
        'url'     => 'nullable|url',
        'file'    => 'nullable|file|max:10240',
    ];

    public function markComplete(){
        CourseProgress::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'course_id' => $this->course->id,
                'course_content_id' => $this->content->id,
            ],
            [
                'is_completed' => true,
            ]
        );
        flash()->success("Berhasil menyelesaikan {$this->content->type_formatted}.", [], 'Sukses');
    }

    public function playQuiz(){
        $attempt = QuizAttempt::create(
            [
                'quiz_id' => $this->content->quiz->id,
                'user_id' => Auth::id(),
                'start_time' => now(),
                'end_time' => now()->addMinutes($this->content->quiz->duration),
                'status' => 'in_progress',
                'total_score' => 0
            ]
        );
        return redirect(route('quiz.player', $attempt));
    }

    public function save()
    {
        $this->validate();

        $path = $this->file ? $this->file->store('assignments', 'public') : null;

        AssignmentSubmission::create([
            'assignment_id' => $this->content->assignment->id,
            'student_id'    => Auth::user()->id,
            'text_answer'    => $this->textAnswer,
            'url'           => $this->url,
            'file_path'     => $path,
            'status'        => 'submitted',
            'submitted_at'  => now(),
        ]);
        flash('Berhasil mengunggah tugas');
        $this->reset(['textAnswer', 'url', 'file']);
        $this->refreshPage();
    }
    public function refreshPage(){
        if($this->content->assignment){
            $this->submission = $this->content->assignment->submission;
        }
    }
    public function confirmDeleteSubmission(){
        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Iya!')
            ->option('denyButtonText', 'Batal')
            ->warning('Apakah kamu yakin ingin menghapus tugas yang telah dikumpulkan ini?');
    }

    #[On('sweetalert:confirmed')]
    public function deleteSubmission()
    {
        $this->submission->delete();
        $this->refreshPage();
        flash()->success('Berhasil menghapus tugas yang dikumpulkan!', [], 'Sukses');
    }

    #[On('sweetalert:denied')]
    public function cancelDeleteSubmission()
    {
        flash()->info('Penghapusan dibatalkan.', [], 'Informasi');
    }
    public function mount($slug, $syllabusId, $courseContentId){
        $this->course = Course::where('slug', $slug)->with(['teacher', 'syllabus.courseContents'])->firstOrFail();
        //$this->content = $course->syllabus->firstWhere('id', $syllabusId)->courseContents->firstWhere('id', $courseContentId);
        $this->content = $this->course->contents()
        ->where('course_contents.id', $courseContentId)
        ->where('course_contents.course_syllabus_id', $syllabusId)
        ->with(['quiz', 'article', 'video', 'assignment.submission', 'courseSyllabus'])
        ->firstOrFail();
        
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = User::find(Auth::id());

        if (!$user->enrolledCourses()->where('course_id', $this->course->id)->exists()) {
            return redirect()->route('course.show', $this->course->slug)
                ->with('error', 'Anda belum terdaftar dalam kursus ini.');
        }

        $syllabus = $this->course->syllabus()->findOrFail($syllabusId);
        $this->content  = $syllabus->courseContents()->findOrFail($courseContentId);

        if (!$this->content->is_unlocked) {
            return redirect()->route('course.show', $this->course->slug)
                ->with('error', 'Konten ini masih terkunci.');
        }

        $this->prevContent = $this->course->contents()
            ->where('global_order', '<', $this->content->global_order)
            ->orderBy('global_order', 'desc')
            ->first();

        // Cari next content
        $this->nextContent = $this->course->contents()
            ->where('global_order', '>', $this->content->global_order)
            ->orderBy('global_order', 'asc')
            ->first();
        if($this->content->assignment){
            $this->submission = $this->content->assignment->submission;
        }
    }
    public function render()
    {
        if($this->content->quiz){
            if(QuizAttempt::where('user_id', Auth::id())->where('quiz_id', $this->content->quiz->id)){
                $attempts = QuizAttempt::where('user_id', Auth::id())->where('quiz_id', $this->content->quiz->id)->orderBy('end_time', 'desc')->paginate(5);
                return view('livewire.course.public.show-content', [
                'data' => $this->attempts ?? $attempts
                ]);
            }
        }
        return view('livewire.course.public.show-content');
    }
}
