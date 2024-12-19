<?php

namespace App\Modules\Forms\Admin;

use Livewire\Form;
use App\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PermissionForm extends Form
{
    use AuthorizesRequests;
    public ?Permission $permission = null;
    public $name, $guard_name, $roles = [];

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions')->ignore($this->permission)
            ],
            'roles' => 'array|nullable',
        ];
    }

    public function setPermission(Permission $permission)
    {
        $this->permission = $permission;
        $this->name = $permission->name;
        $this->guard_name = $permission->guard_name;
        $this->roles = $permission->roles->pluck('name')->toArray();
    }

    public function store()
    {
        $this->authorize('create permissions');
        $permission = Permission::create($this->only(['name']));

        if ($this->roles) {
            $permission->syncRoles($this->roles);
        }
    }

    public function update()
    {
        $this->authorize('update permissions');
        $this->permission->update([
            'name' => $this->name,
        ]);
        $this->permission->syncRoles($this->roles);
    }
}
