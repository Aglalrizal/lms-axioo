<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $title;
    public $role;
    public $formtitle;
    public $editform=false;
    public $changePassword=false;

    public $user;

    public $username;
    public $email;
    public $password;
    public function rules()
    {
        $rules = [
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('users', 'username')->ignore($this->user?->id),
            ],
            'email' => [
                'required',
                'email',
                'min:8',
                Rule::unique('users', 'email')->ignore($this->user?->id),
            ],
        ];

        if ($this->editform && $this->changePassword) {
            $rules['password'] = 'required|min:8';
        }

        if (!$this->editform) {
            $rules['password'] = 'required|min:8';
        }

        return $rules;
    }

    public function mount(){
        $this->title = Str::of($this->role)->replace('-', ' ')->title(); 
        $this->formtitle = "Buat ".$this->title;
    }

    public function save(){
        $this->validate();
        $data = $this->validate();
        $user = User::create($data);
        $user->assignRole($this->role??'student');
        $this->dispatch('refresh-users'); 
        flash()->success('Berhasil menambah '.$this->title.'!');
        $this->reset(['username', 'email', 'password', 'formtitle', 'changePassword', 'editform']);
    }


    #[On('reset-modal')]
    public function close(){
        $this->resetValidation();
        $this->reset(['username', 'email', 'password', 'formtitle', 'changePassword', 'editform']);
    }

    #[On('edit-mode')]
    public function edit($id){
        //dd($id);
        $this->editform=true;
        $this->formtitle='Edit '.$this->title;
        $this->user=User::findOrfail($id);
        $this->username=$this->user->username;
        $this->email=$this->user->email;
        $this->password = "";
    }
    public function update(){
        $this->validate();
        $validated=$this->validate();
        $original = [
            'username' => $this->user->username,
            'email' => $this->user->email
        ];

        $current = [
            'username' => $validated['username'],
            'email' => $validated['email'],
        ];

        $passwordChanged = isset($validated['password']);

        if ($original === $current && !$passwordChanged) {
            flash()->info('Tidak ada perubahan data.');
            $this->dispatch('refresh-users');
            return;
        }

        $this->user->update($validated);
        flash()->success('Berhasil memperbarui data '.$this->title.'.');
        $this->dispatch('refresh-users');
        $this->reset(['username', 'email', 'password', 'formtitle', 'changePassword', 'editform']);
    }
    public function render()
    {
        return view('livewire.admin.user.create');
    }
}
