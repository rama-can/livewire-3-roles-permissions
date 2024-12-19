<?php

namespace App\Modules\Forms\Admin;

use Livewire\Form;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoleForm extends Form
{
    use AuthorizesRequests;
    public ?Role $role = null;
    public $name, $guard_name, $permissions = [];

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($this->role)
            ],
            'permissions' => 'array|nullable',
        ];
    }

    public function setRole(Role $role)
    {
        $this->role = $role;
        $this->name = $role->name;
        $this->guard_name = $role->guard_name;
        $this->permissions = $role->permissions->pluck('name')->toArray();
    }

    public function store()
    {
        $this->authorize('create roles');
        $role = Role::create($this->only(['name']));

        if ($this->permissions) {
            $role->syncPermissions($this->permissions);
        }
    }

    public function update()
    {
        $this->authorize('update roles');
        $this->role->update([
            'name' => $this->name,
        ]);

        $this->role->syncPermissions($this->permissions);
    }
}
