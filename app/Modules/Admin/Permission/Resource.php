<?php

namespace App\Modules\Admin\Permission;

use App\Models\Role;
use Livewire\Component;
use App\Models\Permission;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Artisan;
use App\Modules\Forms\Admin\PermissionForm;

class Resource extends Component
{
    use Interactions;

    public PermissionForm $form;
    #[Locked]
    public $dataId = null;
    public $isModalOpen = false;

    #[Computed]
    public function roles()
    {
        return Role::where('name', '!=', 'Super Admin')->get();
    }

    #[On('modal-form')]
    public function modalForm($id = null)
    {
        if ($id && $this->authorize('update permissions')) {
            $role = Permission::findOrFail($id);
            $this->form->setPermission($role);
            $this->dataId = $id;
        } else {
            $this->authorize('create permissions');
        }
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->form->validate();
        try {
            if ($this->dataId) {
                $this->form->update();
                $message = 'Record updated successfully!';
            } else {
                $this->form->store();
                $message = 'Record added successfully!';
            }
            Artisan::call('permission:cache-reset');
            $this->toast()->success($message)->send();
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
            ->question('Warning!', 'Are you sure you want to delete this permission?')
            ->confirm('Confirm', 'delete', 'Confirmed Successfully')
            ->cancel('Cancel')
            ->send();
    }

    public function delete(): void
    {
        $this->authorize('delete permissions');
        try {
            $data = Permission::findOrFail($this->dataId);
            Artisan::call('permission:cache-reset');
            $data->delete();
            $this->dispatch('refreshDatatable');
            $this->toast()->success('Permission deleted successfully!')->send();
            $this->dataId = null;
        } catch (\Throwable $th) {
            $this->toast()->error($th->getMessage())->send();
        }
    }

    public function resetModal()
    {
        $this->isModalOpen = false;
        $this->dataId = null;
        $this->form->reset();
        $this->resetValidation();
    }

    #[Title('Permission Management')]
    public function render()
    {
        return view('pages.admin.permission.resource');
    }
}
