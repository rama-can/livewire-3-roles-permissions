<?php

namespace App\Modules\Admin\ShortLink;

use Livewire\Component;
use App\Models\ShortLink;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;
use TallStackUi\Traits\Interactions;

class Resource extends Component
{
    use Interactions;

    #[Locked]
    public $dataId = null;
    public $name;
    public $url;
    public $code;
    public $expires_at = null;

    public $isModalOpen = false;

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'code' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date',
        ];
    }

    public function mount()
    {
        $this->authorize('read short-links');
    }

    #[On('modal-form')]
    public function modalForm($id = null)
    {
        if ($id && $this->authorize('update short-links')) {
            $link = ShortLink::findOrFail($id);
            $this->dataId = $link->id;
            $this->name = $link->name;
            $this->url = $link->url;
            $this->code = $link->code;
            $this->expires_at = $link->expires_at;
        } else {
            $this->authorize('create short-links');
            $this->reset();
        }
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->authorize('create short-links');
        // Generate code if not exists
        if (!$this->dataId) {
            do {
                $this->code = generateUniqueCode(8);
            } while (ShortLink::where('code', $this->code)->exists());
        }

        $this->validate();
        try {

            ShortLink::updateOrCreate(['id' => $this->dataId], [
                'name' => $this->name,
                'url' => $this->url,
                'code' => $this->code,
                'expires_at' => $this->expires_at ?? null,
            ]);

            $this->toast()->success('Short Link saved successfully')->send();
            $this->dispatch('refreshDatatable');
            $this->resetModal();
        } catch (\Exception $th) {
            $this->toast()->error($th->getMessage())->send();
        }
    }

    #[On('delete-confirmation')]
    public function confirmDelete($id): void
    {
        $this->dataId = $id;

        $this->dialog()
            ->question('Warning!', 'Are you sure you want to delete this Short Link?')
            ->confirm('Confirm', 'delete', 'Confirmed Successfully')
            ->cancel('Cancel')
            ->send();
    }

    public function delete(): void
    {
        $this->authorize('delete short-links');
        try {
            $data = ShortLink::findOrFail($this->dataId);
            $data->delete();
            $this->dispatch('refreshDatatable');
            $this->toast()->success('Short Link deleted successfully!')->send();
            $this->dataId = null;
        } catch (\Throwable $th) {
            $this->toast()->error($th->getMessage())->send();
        }
    }

    public function resetModal()
    {
        $this->dataId = null;
        $this->name = null;
        $this->url = null;
        $this->code = null;
        $this->expires_at = null;
        $this->isModalOpen = false;
        $this->resetErrorBag();
    }

    #[Title('Translation Management')]
    public function render()
    {
        return view('pages.admin.short-link.resource');
    }
}
