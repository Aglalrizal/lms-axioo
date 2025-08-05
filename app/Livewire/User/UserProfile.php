<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.authenticated.dashboard')]

class UserProfile extends Component
{
    use WithFileUploads;

    public ?User $user;

    public $photo, $first_name, $surname, $email, $id_number, $phone_number, $place_of_birth, $date_of_birth, $city, $address, $education, $institution, $major;
    public $profile_picture_path = '';

    protected function rules()
    {
        return [
            'photo' => 'nullable|image|max:2048', // 2MB max
            'first_name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->user)
            ],
            'id_number' => 'nullable|string|max:16',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
        ];
    }

    protected function messages()
    {
        $messages = [];

        $fields = [
            'first_name',
            'surname',
            'email',
            'id_number',
            'place_of_birth',
            'date_of_birth',
            'city',
            'address',
            'education',
            'institution',
            'major'
        ];

        foreach ($fields as $field) {
            $messages[$field . '.max'] = ':attribute tidak boleh lebih dari :value karakter.';
        }

        // Special cases
        $messages['email.required'] = ':attribute perlu diisi.';
        $messages['photo.image'] = 'File yang dipilih harus berupa gambar.';
        $messages['photo.max'] = 'Ukuran gambar tidak boleh lebih dari 2MB.';

        return $messages;
    }

    public function mount()
    {
        $user = auth()->user();

        $this->user = $user;
        $this->profile_picture_path = $user->profile_picture_path;
        $this->first_name = $user->first_name;
        $this->surname = $user->surname;
        $this->email = $user->email;
        $this->id_number = $user->id_number;
        $this->place_of_birth = $user->place_of_birth;
        $this->date_of_birth = $user->date_of_birth;
        $this->city = $user->city;
        $this->address = $user->address;
        $this->education = $user->education;
        $this->institution = $user->institution;
        $this->major = $user->major;
    }

    public function updated($property)
    {
        if ($property === 'photo') {
            $this->profile_picture_path = $this->photo ? $this->photo->temporaryUrl() : '';
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->photo) {
            // Delete old profile picture if exists
            if ($this->user->profile_picture_path) {
                Storage::disk('public')->delete($this->user->profile_picture_path);
            }

            $this->profile_picture_path = $this->photo->storePublicly('user_profile_photos', ['disk' => 'public']);
        }

        $updateData = $this->only([
            'first_name',
            'surname',
            'email',
            'id_number',
            'place_of_birth',
            'date_of_birth',
            'city',
            'address',
            'education',
            'institution',
            'major'
        ]);

        if ($this->profile_picture_path) {
            $updateData['profile_picture_path'] = $this->profile_picture_path;
        }

        $this->user->update($updateData);

        // Reset photo after saving
        $this->photo = null;

        flash()->success('Profil berhasil diperbarui!');
    }

    public function confirmation()
    {
        sweetalert()
            ->showDenyButton()
            ->option('confirmButtonText', 'Ya, Hapus Foto Profil')
            ->option('denyButtonText', 'Batal')
            ->option('id', $this->user->id)
            ->warning('Apakah Anda yakin ingin menghapus foto profil ini?');
    }

    #[On('sweetalert:confirmed')]
    public function removePhoto()
    {
        // Delete existing photo from storage
        if ($this->user->profile_picture_path) {
            Storage::disk('public')->delete($this->user->profile_picture_path);
        }

        $this->photo = null;
        $this->profile_picture_path = '';

        $this->user->update(['profile_picture_path' => null]);

        flash()->success('Foto profil berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
