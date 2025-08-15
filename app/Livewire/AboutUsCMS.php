<?php

namespace App\Livewire;

use App\Models\AboutUs;
use App\Models\Mission;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]

class AboutUsCMS extends Component
{
    public $tentangKami = '';
    public $visiKami = '';
    public $misiKami = [];
    public $aboutUsId = null;

    public function rules()
    {
        return [
            'tentangKami' => 'required|string',
            'visiKami' => 'required|string',
            'misiKami' => 'required|array|min:1',
            'misiKami.*.title' => 'required|string|max:255',
            'misiKami.*.description' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'tentangKami.required' => 'Tolong masukkan deskripsi Tentang Kami.',
            'visiKami.required' => 'Tolong masukkan deskripsi Visi Kami.',
            'misiKami.required' => 'Tolong tambahkan setidaknya satu Misi.',
            'misiKami.*.title.required' => 'Tolong masukkan judul untuk setiap Misi.',
            'misiKami.*.description.required' => 'Tolong masukkan deskripsi untuk setiap Misi.',
        ];
    }

    public function mount()
    {
        $aboutUs = AboutUs::with('missions')->first();

        if ($aboutUs) {
            $this->aboutUsId = $aboutUs->id;
            $this->tentangKami = $aboutUs->about_description;
            $this->visiKami = $aboutUs->vision_description;
            $this->misiKami = $aboutUs->missions->toArray();
        } else {
            $this->misiKami = [['id' => null, 'title' => '', 'description' => '']];
        }
    }

    public function addMisi()
    {
        $this->misiKami[] = ['id' => null, 'title' => '', 'description' => ''];
    }

    public function removeMisi($index)
    {
        if (count($this->misiKami) > 1) {
            unset($this->misiKami[$index]);
            $this->misiKami = array_values($this->misiKami); // Re-index array
        }
    }

    public function save()
    {
        $this->validate();

        // Create or update AboutUs
        $aboutUs = AboutUs::updateOrCreate(
            ['id' => $this->aboutUsId],
            [
                'about_description' => $this->tentangKami,
                'vision_description' => $this->visiKami
            ]
        );

        $this->aboutUsId = $aboutUs->id;

        // Get existing mission IDs
        $existingMissionIds = collect($this->misiKami)
            ->pluck('id')
            ->filter()
            ->toArray();

        // Delete missions that are no longer in the list
        if ($existingMissionIds) {
            Mission::where('about_us_id', $aboutUs->id)
                ->whereNotIn('id', $existingMissionIds)
                ->delete();
        } else {
            // If no existing missions, delete all missions for this about_us
            Mission::where('about_us_id', $aboutUs->id)->delete();
        }

        // Create or update missions
        foreach ($this->misiKami as $misi) {
            if ($misi['id']) {
                // Update existing mission
                Mission::where('id', $misi['id'])->update([
                    'title' => $misi['title'],
                    'description' => $misi['description']
                ]);
            } else {
                // Create new mission
                Mission::create([
                    'about_us_id' => $aboutUs->id,
                    'title' => $misi['title'],
                    'description' => $misi['description']
                ]);
            }
        }

        flash()->success('About Us content updated successfully!');
    }

    public function render()
    {
        return view('livewire.about-us-c-m-s');
    }
}
