<?php

namespace App\Livewire\User;

use App\Models\StudyPlan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.dashboard')]

class UserDashboard extends Component
{
    public ?StudyPlan $studyPlan;

    #[Validate('required|string|max:255')]
    public $kelas;

    #[Validate('required|string|max:255')]
    public $program;

    #[Validate('required|date')]
    public $tanggal;

    #[Validate('required|integer|min:0|max:100')]
    public $target;

    public $showModal = false;

    public $action;

    public $user;

    public $courses;

    public $totalEnrolledCourses;

    public $recommendCourses;

    public $rencanaBelajar;

    public $totalCompletedCourses;

    public function messages()
    {
        return [
            'kelas.required' => ':attribute harus diisi.',
            'program.required' => ':attribute harus diisi.',
            'tanggal.required' => ':attribute harus diisi.',
            'target.required' => ':attribute harus diisi.',
            'target.min' => ':attribute tidak boleh kurang dari :value.',
            'target.max' => ':attribute tidak boleh lebih dari :value.',
        ];
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->user->loadCount('enrolledCourses');

        $this->totalEnrolledCourses = $this->user->enrolled_courses_count;

        $this->totalCompletedCourses = $this->user
            ->enrolledCourses()
            ->select('courses.id')
            ->withCount('contents as total_contents')
            ->withCount(['progresses as completed_contents' => function ($query) {
                $query->where('student_id', Auth::id());
                $query->where('is_completed', true);
            }])
            ->havingRaw('completed_contents = total_contents')
            ->count();
    }

    public function openModal($studyPlanId = null)
    {
        if ($studyPlanId) {
            $this->studyPlan = StudyPlan::findOrFail($studyPlanId);

            $this->kelas = $this->studyPlan->kelas;
            $this->program = $this->studyPlan->program;
            $this->tanggal = $this->studyPlan->tanggal;
            $this->target = $this->studyPlan->target;

            $this->action = 'update';
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetExcept(['user', 'totalEnrolledCourses', 'totalCompletedCourses', 'rencanaBelajar']);
    }

    public function store()
    {
        $this->validate();

        StudyPlan::create($this->only([
            'kelas',
            'program',
            'tanggal',
            'target',
        ]) + ['user_id' => Auth::user()->id]);

        flash()->success('Rencana belajar berhasil dibuat!');

        $this->closeModal();
    }

    public function update()
    {
        $this->validate();

        $this->studyPlan->update(
            $this->only([
                'kelas',
                'program',
                'tanggal',
                'target',
            ])
        );

        flash()->success('Rencana belajar berhasil diperbarui!');

        $this->closeModal();
    }

    public function confirmation()
    {
        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Ya, hapus!')
            ->option('denyButtonText', 'Batal')
            ->warning('Hapus rencana belajar ini?');
    }

    #[On('sweetalert:confirmed')]
    public function delete()
    {
        $this->studyPlan->delete();

        flash()->success('Rencana belajar berhasil dihapus!');

        $this->closeModal();
    }

    public function render()
    {
        $this->rencanaBelajar = StudyPlan::query()
            ->where('user_id', $this->user->id)
            ->get();

        $this->courses = Auth::user()
            ->courseProgressInformation()
            // ->havingRaw('completed_contents < total_contents OR total_contents = 0')
            ->get()
            ->take(4)
            ->map(function ($course) {
                $course->progress_percentage = $course->total_contents > 0
                    ? round(($course->completed_contents / $course->total_contents) * 100)
                    : 0;

                return $course;
            });

        $this->recommendCourses = $this->user->getIntelligentRecommendations(4);

        return view('livewire.user-dashboard', [
            // 'courses' => $courses,
        ]);
    }
}
