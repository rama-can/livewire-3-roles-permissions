<?php

namespace App\Modules\Admin\Role;

use Livewire\Component;
use App\Models\Permission;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Spatie\Permission\Models\Role;
use TallStackUi\Traits\Interactions;
use App\Modules\Forms\Admin\RoleForm;

class Resource extends Component
{
    use Interactions;

    public RoleForm $form;
    #[Locked]
    public $roleId = null;
    public $isModalOpen = false;

    public function mount()
    {
        $this->authorize('read roles');
    }

    #[Computed]
    public function permissions()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            $parts = explode(' ', $permission->name);
            return isset($parts[1]) ? $parts[1] : 'other';
            // return count($parts) > 1 ? $parts[1] : $parts[0];
        });

        return $permissions;
    }

    #[On('modal-form')]
    public function modalForm($id = null)
    {
        if ($id && $this->authorize('update roles')) {
            $role = Role::findOrFail($id);
            $this->form->setRole($role);
            $this->roleId = $id;
        } else {
            $this->authorize('create roles');
        }
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->form->validate();
        try {
            if ($this->roleId) {
                $this->form->update();
                $message = 'Record updated successfully!';
            } else {
                $this->form->store();
                $message = 'Record added successfully!';
            }
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
        $this->authorize('delete roles');
        $this->roleId = $id;
        $this->dialog()
            ->question('Warning!', 'Are you sure you want to delete this role?')
            ->confirm('Confirm', 'delete', 'Confirmed Successfully')
            ->cancel('Cancel')
            ->send();
    }

    public function delete(): void
    {
        $this->authorize('delete roles');
        try {
            $data = Role::findOrFail($this->roleId);
            $data->delete();
            $this->dispatch('refreshDatatable');
            $this->toast()->success('Role deleted successfully!')->send();
            $this->roleId = null;
        } catch (\Throwable $th) {
            $this->toast()->error($th->getMessage())->send();
        }
    }

    public function resetModal()
    {
        $this->isModalOpen = false;
        $this->roleId = null;
        $this->form->reset();
        $this->resetValidation();
    }

    #[Title('Role Management')]
    public function render()
    {
        return view('pages.admin.role.resource');
    }
}
