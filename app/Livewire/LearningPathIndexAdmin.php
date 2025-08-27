<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\LearningPath;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class LearningPathIndexAdmin extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedPath = null;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function confirmDelete($pathId)
    {
        $this->selectedPath = LearningPath::findOrFail($pathId);

        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Ya, Hapus Tiket!')
            ->option('denyButtonText', 'Batal')
            ->warning('Apakah Anda yakin ingin menghapus tiket ini?');
    }

    #[On('sweetalert:confirmed')]
    public function deletePath()
    {
        if ($this->selectedPath) {
            $this->selectedPath->delete();
            flash()->success('Learning Path berhasil dihapus!', [], 'Sukses');
            $this->selectedPath = null;
        }
    }

    #[On('sweetalert:denied')]
    public function cancelDelete()
    {
        $this->selectedPath = null;
    }

    public function togglePublish($pathId)
    {
        $path = LearningPath::findOrFail($pathId);
        $path->update(['is_published' => !$path->is_published]);

        $status = $path->is_published ? 'dipublikasikan' : 'di-unpublish';
        flash()->success("Learning Path berhasil {$status}!", [], 'Sukses');
    }

    public function render()
    {
        $learningPaths = LearningPath::with(['steps.course'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.learning-path-index-admin', [
            'learningPaths' => $learningPaths
        ]);
    }
}
