<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.authenticated.dashboard')]

class UserCertificates extends Component
{
    public function render()
    {
        return view('livewire.user-certificates', [
            'certificates' => [] // Assuming you will fetch the certificates from a model or service,
        ]);
    }
}
