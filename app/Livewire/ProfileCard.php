<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProfileCard extends Component
{
    use WithFileUploads;

    public $userId;
    public $user;

    public $profile_picture;
    public $first_name, $surname, $id_number, $phone_number, $place_of_birth, $date_of_birth, $address;
    public $education, $institution;

    public function rules()
    {
        return [
            'profile_picture' => 'nullable|image|max:2048',
            'id_number' => 'nullable|string|max:30',
            'phone_number' => 'nullable|string|regex:/^\+?[0-9]{8,15}$/',
            'first_name' => 'required|string|max:50',
            'surname' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:50',
            'education' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
        ];
    }

    public function mount($user)
    {
        $this->user = \App\Models\User::where('username', $user->username)->firstOrFail();

        $this->first_name = Str::title($this->user->first_name);
        $this->surname = Str::title($this->user->surname);
        $this->id_number = $this->user->id_number;
        $this->phone_number = $this->user->phone_number;
        $this->place_of_birth = $this->user->place_of_birth;
        $this->date_of_birth = $this->user->date_of_birth;
        $this->address = $this->user->address;
        $this->education = $this->user->education;
        $this->institution = $this->user->institution;
    }

    public function render()
    {
        return view('livewire.profile-card', [
            'role' => $this->user->getRoleNames()->first()
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
            $filename = 'profile_' . now()->timestamp . '.' . $this->profile_picture->getClientOriginalExtension();
            $path = $this->profile_picture->storeAs('profile-pictures', $filename, 'public');
            $validated['profile_picture'] = $path;
        } else {
            unset($validated['profile_picture']); // jangan kosongin field jika tidak diganti
        }

        $this->user->update($validated);

        flash()->success('Profil berhasil diperbarui!');
        return redirect()->route('admin.user', ['role' =>  $this->user->getRoleNames()->first()]);
    }
}
