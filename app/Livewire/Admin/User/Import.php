<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Imports\UsersImport;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.dashboard')]

class Import extends Component
{
    use WithFileUploads;
    #[Rule('required|file|mimes:csv,xlsx|max:2048')]
    public $file;
    public $previewUsers = [];
    public $duplicates = [];
    public function import(){
        foreach ($this->previewUsers as $userData) {
            if ($userData['duplicate']) {
                continue;
            }

            User::create([
                'username' => $userData['username'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ])->assignRole('student');
        }

        flash()->success('Import selesai!');
        $this->reset(['file', 'previewUsers', 'duplicates']);
        $this->dispatch('refresh-users');
        return redirect()->route('admin.user', ['role' => 'student']);
    }
    // #[On('download-template')]
    public function downloadTemplate(){
        $filename ='template.xlsx';
        $path = storage_path('app/public/'.$filename);
        return response()->download($path, $filename);
    }
    public function render()
    {
        return view('livewire.admin.user.import');
    }

    public function previewImport()
    {
        $this->validate();

        $this->reset(['previewUsers', 'duplicates']);

        $collection = (new UsersImport)->toCollection($this->file);
        $this->previewUsers = $collection[0]->map(function ($row) {
            $isDuplicate = User::where('email', $row['email'])->orWhere('username', $row['username'])->exists();
            if ($isDuplicate) {
                $this->duplicates[] = $row['email'];
            }
            return [
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => $row['password'],
                'duplicate' => $isDuplicate,
            ];
        })->toArray();

    }

}
