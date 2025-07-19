<?php

namespace App\Livewire\Admin\Reports\ActivityLog;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Spatie\Activitylog\Models\Activity;

#[Layout('layouts.dashboard')]

class Index extends Component
{

    use WithPagination;

    public $search = '';

    public function render()
    {
        $activities = Activity::latest()
            ->when($this->search, fn($q) =>
                $q->where('description', 'like', '%'.$this->search.'%')
            )
            ->paginate(10);

        return view('livewire.admin.reports.activity-log.index', compact('activities'));
    }
}
