<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('layouts.dashboard')]
class AccountCard extends Component
{
    public $user;

    #[Validate('required|email')]
    public $old_email;
    #[Validate('required|email')]
    public $new_email;
    #[Validate('required')]
    public $old_password;
    #[Validate('required')]
    public $new_password;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function resetField()
    {
        $this->old_email = '';
        $this->new_email = '';
        $this->old_password = '';
        $this->new_password = '';
    }

    public function messages()
    {
        return [
            'old_email.required' => 'Email lama harus diisi.',
            'new_email.required' => 'Email baru harus diisi.',
            'old_password.required' => 'Password lama harus diisi.',
            'new_password.required' => 'Password baru harus diisi.',
        ];
    }

    public function changeEmail()
    {
        $this->validateOnly('old_email|new_email');

        if ($this->old_email == $this->user->email) {

            $this->user->update([
                'email' => $this->new_email
            ]);

            flash()->success('Email berhasil diubah.');

            $this->resetField();
        } else {
            flash()->error('Email lama tidak sesuai ');
        }
    }

    public function changePassword()
    {
        $this->validateOnly('old_password|new_password');

        if (Hash::check($this->old_password, $this->user->password)) {
            $this->user->update([
                'password' => Hash::make($this->new_password)
            ]);

            flash()->success('Password berhasil diubah.');

            $this->resetField();
        } else {
            flash()->error('password lama tidak sesuai ');
        }
    }


    public function render()
    {
        return view('livewire.account-card');
    }
}
