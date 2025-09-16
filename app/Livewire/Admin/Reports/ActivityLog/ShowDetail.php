<?php

namespace App\Livewire\Admin\Reports\ActivityLog;

use Livewire\Attributes\On;
use Livewire\Component;

class ShowDetail extends Component
{
    public $log = null;

    #[On('show-log-detail')]
    public function loadLog($id)
    {
        $this->log = \Spatie\Activitylog\Models\Activity::findOrFail($id);
    }

    #[On('reset-log-detail')]
    public function resetLog()
    {
        $this->log = null;
    }

    public function render()
    {
        return view('livewire.admin.reports.activity-log.show-detail');
    }
}
