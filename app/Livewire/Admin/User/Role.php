<?php

namespace App\Livewire\Admin\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Role extends Component
{
    public function render()
    {
        return view('livewire.admin.user.role');
    }
}
