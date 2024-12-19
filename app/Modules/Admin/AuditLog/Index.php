<?php

namespace App\Modules\Admin\AuditLog;

use Livewire\Component;
use App\Models\AuditLog;
use Livewire\Attributes\Title;
use TallStackUi\Traits\Interactions;

class Index extends Component
{
    use Interactions;

    public function confirmDelete(): void
    {
        $this->dialog()
            ->question('Warning!', 'Are you sure you want to delete this permission?')
            ->confirm('Confirm', 'delete', 'Confirmed Successfully')
            ->cancel('Cancel')
            ->send();
    }

    public function delete(): void
    {
        $this->authorize('delete audit-logs');
        try {
            AuditLog::truncate();
            $this->dispatch('refreshDatatable');
            $this->toast()->success('Audit Log truncated successfully!')->send();
        } catch (\Throwable $th) {
            $this->toast()->error($th->getMessage())->send();
        }
    }

    #[Title('Audit Log')]
    public function render()
    {
        return view('pages.admin.audit-log.index');
    }
}
