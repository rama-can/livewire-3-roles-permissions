<?php

namespace App\Modules\Admin\AuditLog;

use Livewire\Component;
use App\Models\AuditLog;
use Livewire\Attributes\Title;

class View extends Component
{
    public $data;
    public $properties;

    public function mount($id)
    {
        $this->authorize('read audit-logs');
        $log = AuditLog::findOrFail($id);
        $this->data = $log;
        $this->properties = json_decode($log->properties);
    }

    #[Title('Audit Log')]
    public function render()
    {
        return view('pages.admin.audit-log.view');
    }
}
