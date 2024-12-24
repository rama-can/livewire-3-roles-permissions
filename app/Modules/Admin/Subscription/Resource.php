<?php

namespace App\Modules\Admin\Subscription;

use Livewire\Component;
use App\Models\Subscriber;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use TallStackUi\Traits\Interactions;

class Resource extends Component
{
    use Interactions;

    public $dataId;

    #[On('delete-confirmation')]
    public function confirmDelete($id): void
    {
        $this->dataId = $id;

        $this->dialog()
            ->question('Warning!', 'Are you sure you want to delete this Subscription?')
            ->confirm('Confirm', 'delete', 'Confirmed Successfully')
            ->cancel('Cancel')
            ->send();
    }

    public function delete(): void
    {
        $this->authorize('delete subscriptions');
        try {
            $data = Subscriber::findOrFail($this->dataId);
            $data->delete();
            $this->dispatch('refreshDatatable');
            $this->toast()->success('Subscription deleted successfully!')->send();
            $this->dataId = null;
        } catch (\Throwable $th) {
            $this->toast()->error($th->getMessage())->send();
        }
    }

    #[Title('Subscription')]
    public function render()
    {
        return view('pages.admin.subscription.resource', [
            'count' => Subscriber::count()
        ]);
    }
}
