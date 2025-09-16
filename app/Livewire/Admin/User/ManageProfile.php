<?php

namespace App\Livewire\Admin\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]

class ManageProfile extends Component
{
    public $user;

    public function mount($username)
    {
        $this->user = \App\Models\User::where('username', $username)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.admin.user.manage-profile');
    }
}
