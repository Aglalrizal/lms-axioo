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
    public $startDate;
    public $endDate;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function render()
    {
        $activities = Activity::latest()
        ->when($this->search, fn($q) =>
            $q->where('description', 'like', '%' . $this->search . '%')
        )
        ->when($this->startDate, fn($q) =>
            $q->whereDate('created_at', '>=', $this->startDate)
        )
        ->when($this->endDate, fn($q) =>
            $q->whereDate('created_at', '<=', $this->endDate)
        )
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate(10);

        return view('livewire.admin.reports.activity-log.index', compact('activities'));
    }
    public function resetDate(){
        $this->startDate = null;
        $this->endDate = null;
    }
}
