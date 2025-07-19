<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class Role extends Component
{
    public function render()
    {
        return view('livewire.admin.user.role');
    }
}
