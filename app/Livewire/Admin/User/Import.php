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
use PhpOffice\PhpSpreadsheet\Shared\Date;

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
                'username'         => $userData['username'],
                'email'            => $userData['email'],
                'password'         => Hash::make($userData['password']),
                'id_number'        => $userData['id_number'] ?? null,
                'phone_number'     => $userData['phone_number'] ?? null,
                'first_name'       => $userData['first_name'] ?? null,
                'surname'          => $userData['surname'] ?? null,
                'date_of_birth'    => $userData['date_of_birth'] ?? null,
                'place_of_birth'   => $userData['place_of_birth'] ?? null,
                'education'        => $userData['education'] ?? null,
                'institution'      => $userData['institution'] ?? null,
                'address'          => $userData['address'] ?? null,
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
        $collection = (new UsersImport)->toCollection($this->file)[0];
        $emailCounts = [];
        $usernameCounts = [];
        foreach ($collection as $row) {
            $email = strtolower(trim($row['email']));
            $username = strtolower(trim($row['username']));
            $emailCounts[$email] = ($emailCounts[$email] ?? 0) + 1;
            $usernameCounts[$username] = ($usernameCounts[$username] ?? 0) + 1;
        }
        $this->previewUsers = $collection->map(function ($row) use ($emailCounts, $usernameCounts) {
            $email = strtolower(trim($row['email']));
            $username = strtolower(trim($row['username']));
            $isDuplicateDB = User::where('email', $email)->orWhere('username', $username)->exists();
            $isDuplicateFile = $emailCounts[$email] > 1 || $usernameCounts[$username] > 1;
            $isDuplicate = $isDuplicateDB || $isDuplicateFile;
            if ($isDuplicate) {
                $this->duplicates[] = $email;
            }
            $rawDate = $row['date_of_birth'] ?? null;
            $convertedDate = null;
            if (is_numeric($rawDate)) {
                try {
                    $convertedDate = Date::excelToDateTimeObject($rawDate)->format('Y-m-d');
                } catch (\Exception $e) {
                    $convertedDate = null;
                }
            } elseif ($rawDate) {
                try {
                    $convertedDate = date('Y-m-d', strtotime($rawDate));
                } catch (\Exception $e) {
                    $convertedDate = null;
                }
            }
            return [
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => $row['password'],
                'id_number'        => $row['id_number'] ?? null,
                'phone_number'     => $row['phone_number'] ?? null,
                'first_name'       => $row['first_name'] ?? null,
                'surname'          => $row['surname'] ?? null,
                'date_of_birth'    => $convertedDate ?? null,
                'place_of_birth'   => $row['place_of_birth'] ?? null,
                'education'        => $row['education'] ?? null,
                'institution'      => $row['institution'] ?? null,
                'address'          => $row['address'] ?? null,
                'duplicate' => $isDuplicate,
            ];
        })->toArray();
    }
}
