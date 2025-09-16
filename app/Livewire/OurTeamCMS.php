<?php

namespace App\Livewire;

use App\Models\OurTeam;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]

class OurTeamCMS extends Component
{
    use WithFileUploads;

    public $timKami = [];

    public $photos = [];

    protected function rules()
    {
        return [
            'timKami' => 'required|array|min:1',
            'timKami.*.nama' => 'required|string|max:255',
            'timKami.*.deskripsi' => 'required|string',
            'timKami.*.jabatan' => 'required|string|max:120',
            'timKami.*.linkedin' => 'nullable|url',
            'photos.*' => 'required|image|max:2048', // 2MB max
        ];
    }

    protected function messages()
    {
        return [
            'timKami.required' => 'Minimal harus ada satu anggota tim.',
            'timKami.min' => 'Minimal harus ada satu anggota tim.',
            'timKami.*.nama.required' => 'Nama anggota tim wajib diisi.',
            'timKami.*.nama.string' => 'Nama harus berupa teks.',
            'timKami.*.nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'timKami.*.deskripsi.required' => 'Deskripsi anggota tim wajib diisi.',
            'timKami.*.deskripsi.string' => 'Deskripsi harus berupa teks.',
            'timKami.*.jabatan.required' => 'Jabatan anggota tim wajib diisi.',
            'timKami.*.jabatan.string' => 'Jabatan harus berupa teks.',
            'timKami.*.jabatan.max' => 'Jabatan tidak boleh lebih dari 120 karakter.',
            'timKami.*.linkedin.url' => 'Format URL LinkedIn tidak valid.',
            'photos.*.required' => 'Foto anggota tim wajib diunggah.',
            'photos.*.image' => 'File harus berupa gambar.',
            'photos.*.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ];
    }

    public function mount()
    {
        $ourTeams = OurTeam::all();

        if ($ourTeams->isNotEmpty()) {
            $this->timKami = $ourTeams->toArray();

            $this->photos = array_fill(0, count($this->timKami), null);
        } else {
            // Initialize with one empty team member
            $this->timKami = [
                ['id' => null, 'nama' => '', 'deskripsi' => '', 'jabatan' => '', 'linkedin' => '', 'photo_path' => null],
            ];

            $this->photos = [null];
        }
    }

    public function addTim()
    {
        $this->timKami[] = ['id' => null, 'nama' => '', 'deskripsi' => '', 'linkedin' => '', 'photo_path' => null];
        $this->photos[] = null;
    }

    public function removeTim($index)
    {
        if (count($this->timKami) > 1) {
            // Delete photo file if exists
            if ($this->timKami[$index]['photo_path']) {
                Storage::disk('public')->delete($this->timKami[$index]['photo_path']);
            }

            unset($this->timKami[$index]);
            unset($this->photos[$index]);
            $this->timKami = array_values($this->timKami); // Re-index array
            $this->photos = array_values($this->photos); // Re-index array
        }
    }

    public function save()
    {
        $this->validate();

        // Get existing team member IDs
        $existingTeamIds = collect($this->timKami)
            ->pluck('id')
            ->filter()
            ->toArray();

        // Delete team members that are no longer in the list
        if ($existingTeamIds) {
            $deletedTeams = OurTeam::whereNotIn('id', $existingTeamIds)->get();

            foreach ($deletedTeams as $team) {
                if ($team->photo_path) {
                    Storage::disk('public')->delete($team->photo_path);
                }
            }

            OurTeam::whereNotIn('id', $existingTeamIds)->delete();
        } else {
            // If no existing team members, delete all photos and records
            $allTeams = OurTeam::all();

            foreach ($allTeams as $team) {
                if ($team->photo_path) {
                    Storage::disk('public')->delete($team->photo_path);
                }
            }

            OurTeam::truncate();
        }

        // Create or update team members
        foreach ($this->timKami as $index => $team) {
            $photoPath = $team['photo_path'];

            // Handle photo upload
            if ($this->photos[$index]) {
                // Delete old photo if exists
                if ($photoPath) {
                    Storage::disk('public')->delete($photoPath);
                }
                // Store new photo
                $photoPath = $this->photos[$index]->store('team_images', 'public');
            }

            if ($team['id']) {
                // Update existing team member
                OurTeam::where('id', $team['id'])->update([
                    'nama' => $team['nama'],
                    'deskripsi' => $team['deskripsi'],
                    'jabatan' => $team['jabatan'],
                    'linkedin' => $team['linkedin'],
                    'photo_path' => $photoPath,
                ]);
            } else {
                // Create new team member
                OurTeam::create([
                    'nama' => $team['nama'],
                    'deskripsi' => $team['deskripsi'],
                    'jabatan' => $team['jabatan'],
                    'linkedin' => $team['linkedin'],
                    'photo_path' => $photoPath,
                ]);
            }
        }

        // Reload data from database to get updated photo_path
        $this->timKami = OurTeam::all()->toArray();

        // Reset photos array
        $this->photos = array_fill(0, count($this->timKami), null);

        flash()->success('Tim Kami berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.our-team-c-m-s');
    }
}
