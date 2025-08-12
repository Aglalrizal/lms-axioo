<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\StudyPlan;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

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

    public function openModal($studyPlanId = null)
    {
        if ($studyPlanId) {
            $this->studyPlan = StudyPlan::findOrFail($studyPlanId);

            $this->authorize('view', $this->studyPlan);

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
        $this->reset();
    }

    public function store()
    {
        $this->validate();

        StudyPlan::create($this->only([
            'kelas',
            'program',
            'tanggal',
            'target'
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
                'target'
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
        $this->authorize('delete', $this->studyPlan);

        $this->studyPlan->delete();

        flash()->success('Rencana belajar berhasil dihapus!');

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.user-dashboard', [
            'user' => Auth::user(),
            'rencanaBelajar' => StudyPlan::where('user_id', Auth::user()->id)->get(),
        ]);
    }
}
