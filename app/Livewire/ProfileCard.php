<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class ProfileCard extends Component
{
    use WithFileUploads;

    public $userId;

    public $user;

    public $profile_picture;

    public $first_name;

    public $surname;

    public $id_number;

    public $phone_number;

    public $place_of_birth;

    public $date_of_birth;

    public $address;

    public $city;

    public $education;

    public $institution;

    public $major;

    public function rules()
    {
        return [
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'first_name' => 'required|string|max:50',
            'surname' => 'nullable|string|max:50',

            'id_number' => 'nullable|string|max:30|regex:/^[A-Za-z0-9\-]+$/',

            'phone_number' => [
                'required',
                'string',
                'regex:/^\+[0-9]{10,15}$/',
            ],

            'place_of_birth' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date|before:today',

            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',

            'education' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:100',
            'major' => 'nullable|string|max:100',
        ];
    }

    public function messages()
    {
        return [
            'profile_picture.image' => 'Foto profil harus berupa gambar.',
            'profile_picture.mimes' => 'Foto profil hanya boleh berformat: jpeg, png, jpg, webp.',
            'profile_picture.max' => 'Ukuran foto profil tidak boleh lebih dari 2MB.',

            'first_name.required' => 'Nama depan wajib diisi.',
            'first_name.max' => 'Nama depan tidak boleh lebih dari :max karakter.',

            'surname.max' => 'Nama belakang tidak boleh lebih dari :max karakter.',

            'id_number.max' => 'Nomor identitas tidak boleh lebih dari :max karakter.',
            'id_number.regex' => 'Nomor identitas hanya boleh berisi huruf, angka, dan tanda strip (-).',

            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.regex' => 'Nomor telepon harus diawali kode negara dan hanya boleh angka. Contoh: +6281234567890.',

            'place_of_birth.max' => 'Tempat lahir tidak boleh lebih dari :max karakter.',

            'date_of_birth.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',

            'address.max' => 'Alamat tidak boleh lebih dari :max karakter.',
            'city.max' => 'Nama kota tidak boleh lebih dari :max karakter.',

            'education.max' => 'Pendidikan tidak boleh lebih dari :max karakter.',
            'institution.max' => 'Institusi tidak boleh lebih dari :max karakter.',
            'major.max' => 'Jurusan tidak boleh lebih dari :max karakter.',
        ];
    }

    public function mount($username)
    {
        $this->user = \App\Models\User::where('username', $username)->firstOrFail();

        $this->first_name = Str::title($this->user->first_name);
        $this->surname = Str::title($this->user->surname);
        $this->id_number = $this->user->id_number;
        $this->phone_number = $this->user->phone_number;
        $this->place_of_birth = $this->user->place_of_birth;
        $this->date_of_birth = $this->user->date_of_birth;
        $this->address = $this->user->address;
        $this->city = $this->user->city;
        $this->education = $this->user->education;
        $this->institution = $this->user->institution;
        $this->major = $this->user->major;
    }

    public function render()
    {
        return view('livewire.profile-card', [
            'role' => $this->user->getRoleNames()->first(),
        ]);
    }

    public function save()
    {
        $this->validate();
        $validated = $this->validate();

        if ($this->profile_picture) {
            if ($this->user->profile_picture && Storage::disk('public')->exists($this->user->profile_picture)) {
                Storage::disk('public')->delete($this->user->profile_picture);
            }
            $filename = 'profile_'.now()->timestamp.'.'.$this->profile_picture->getClientOriginalExtension();
            $path = $this->profile_picture->storeAs('profile-pictures', $filename, 'public');
            $validated['profile_picture'] = $path;
        } else {
            unset($validated['profile_picture']); // jangan kosongin field jika tidak diganti
        }

        $this->user->update($validated);

        flash()->success('Profil berhasil diperbarui!');
        if (Auth::user()->hasRole('super-admin')) {
            return redirect()->route('admin.user', ['role' => $this->user->getRoleNames()->first()]);
        }
    }
}
