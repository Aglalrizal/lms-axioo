<?php

namespace App\Livewire\Course\Program;

use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $programToDelete;

    #[On('delete-program')]
    public function confirmDelete($id)
    {
        $this->programToDelete = $id;

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Iya!')
            ->option('denyButtonText', 'Batal')
            ->option('id', $id)
            ->warning('Apakah kamu yakin ingin menghapus program ini?', ['Confirm Deletion']);
    }

    #[On('sweetalert:confirmed')]
    public function delete(array $payload)
    {
        $program = \App\Models\Program::find($this->programToDelete);
        if ($program) {
            $program->delete();
            flash()->success('Program berhasil dihapus!', [], 'sukses');
        } else {
            flash()->error('Program tidak ditemukan.');
        }

        $this->programToDelete = null;
        $this->refreshProgramPage();
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        $this->programToDelete = null;
        flash()->info('Penghapusan program dibatalkan');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('refresh-program')]
    public function refreshProgramPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $programs = \App\Models\Program::with('courses')
            ->where(function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.course.program.index', compact('programs'));
    }
}
