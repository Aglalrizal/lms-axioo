<?php

namespace App\Livewire;

use App\Models\AboutUs;
use App\Models\Mission;
use App\Models\OurTeam;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]

class AboutUsPublic extends Component
{
    public function render()
    {
        return view('livewire.about-us-public', [
            'about_us' => AboutUs::firstOrNew(),
            'missions' => Mission::all(),
            'teamMembers' => OurTeam::all(),
        ]);
    }
}
