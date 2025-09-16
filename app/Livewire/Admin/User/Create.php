<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{
    public $title;

    public $role;

    public $formtitle;

    public $editform = false;

    public $changePassword = false;

    public $user;

    public $username;

    public $email;

    public $userRole;

    public $password;

    public function rules()
    {
        $rules = [
            'username' => [
                'required',
                'string',
                'min:5',
                'max:20',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($this->user?->id),
            ],
            'email' => [
                'required',
                'email',
                'min:8',
                Rule::unique('users', 'email')->ignore($this->user?->id),
            ],
            'userRole' => [
                'required',
                'exists:roles,name',
            ],
        ];

        if ($this->editform && $this->changePassword) {
            $rules['password'] = 'required|min:8';
        }

        if (! $this->editform) {
            $rules['password'] = 'required|min:8';
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.min' => 'Username minimal :min karakter.',
            'username.max' => 'Username maksimal :max karakter.',
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, tanda hubung, dan underscore.',
            'username.unique' => 'Username sudah digunakan.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'userRole.required' => 'Role wajib diisi.',
            'userRole.exists' => 'Role tidak ada',

            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal :min karakter.',

        ];
    }

    public function mount()
    {
        $this->title = Str::of($this->role)->replace('-', ' ')->title();
        $this->formtitle = 'Buat '.$this->title;
    }

    public function save()
    {
        $this->userRole = $this->role;
        $this->validate();
        $data = $this->validate();
        $user = User::create($data);
        $user->assignRole($this->role ?? 'student');
        $this->dispatch('refresh-users');
        flash()->success('Berhasil menambah '.$this->title.'!');
        $this->reset(['username', 'email', 'password', 'formtitle', 'changePassword', 'editform']);
    }

    #[On('reset-modal')]
    public function close()
    {
        $this->resetValidation();
        $this->reset(['username', 'email', 'password', 'formtitle', 'changePassword', 'editform']);
    }

    #[On('edit-mode')]
    public function edit($id)
    {
        $this->editform = true;
        $this->formtitle = 'Edit '.$this->title;
        $this->user = User::findOrfail($id);
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->userRole = $this->user->getRoleNames()->first();
        $this->password = '';
    }

    public function update()
    {
        $this->validate();
        $validated = $this->validate();
        $original = [
            'username' => $this->user->username,
            'email' => $this->user->email,
            'role' => $this->user->getRoleNames()->first(),
        ];

        $current = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['userRole'],
        ];

        $passwordChanged = isset($validated['password']);

        if ($original === $current && ! $passwordChanged) {
            flash()->info('Tidak ada perubahan data.');
            $this->dispatch('refresh-users');

            return;
        }

        $this->user->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
        ]);

        if ($passwordChanged) {
            $this->user->update([
                'password' => Hash::make($this->password),
            ]);
        }

        $this->user->removeRole($this->role)->assignRole($this->userRole);

        flash()->success('Berhasil memperbarui data.');
        $this->dispatch('refresh-users');
        $this->reset(['username', 'email', 'userRole', 'password', 'formtitle', 'changePassword', 'editform']);
    }

    public function render()
    {
        return view('livewire.admin.user.create');
    }
}
