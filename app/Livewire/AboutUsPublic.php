<?php

namespace App\Livewire;

use App\Models\AboutUs;
use App\Models\Mission;
use App\Models\OurTeam;
use Livewire\Component;
use App\Models\ContactUs;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout('layouts.app')]

class AboutUsPublic extends Component
{
    #[Validate('required|string|max:64')]
    public $full_name;
    #[Validate('required|email')]
    public $email;
    #[Validate('required|string|max:2000|min:32')]
    public $message;

    public function messages()
    {
        return [
            'full_name.required' => 'Nama lengkap diperlukan',
            'full_name.max' => 'Nama lengkap tidak boleh melebihi 64 karakter',
            'email.required' => 'Email diperlukan',
            'email.email' => 'Email tidak valid',
            'message.required' => 'Pesan diperlukan',
            'message.min' => 'Pesan harus terdiri dari minimal 32 karakter',
            'message.max' => 'Pesan tidak boleh melebihi 2000 karakter',
        ];
    }

    public function submitContactUs()
    {
        $this->validate();

        ContactUs::create($this->only([
            'full_name',
            'email',
            'message',
        ]));

        flash()->success('Pesan berhasil dikirim.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.about-us-public', [
            'about_us' => AboutUs::query()
                ->select('id', 'about_description', 'vision_description')
                ->with('missions:id,about_us_id,title,description')
                ->firstOrNew(),
            'teamMembers' => OurTeam::query()
                ->select('id', 'nama', 'photo_path', 'jabatan', 'deskripsi', 'linkedin')
                ->get(),
        ]);
    }
}
