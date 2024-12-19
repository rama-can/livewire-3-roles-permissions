<?php

namespace App\Modules\Admin\User;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use TallStackUi\Traits\Interactions;
use App\Http\Requests\User\UpdateRequest;
use App\Services\User\UserService;

class Edit extends Component
{
    use Interactions, WithFileUploads;

    public $avatar;
    public $id, $username, $name, $email, $phone_number = '', $zip = '', $country = '', $image, $dob, $role, $password;

    protected $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Computed]
    public function roles()
    {
        return Role::all();
    }

    public function mount($id)
    {
        $this->authorize('update users');
        $user = User::findOrFail($id);
        $this->id = $user->id;
        $this->role = $user->roles->first()->id ?? null;
        $this->username = $user->username;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->zip = $user->zip;
        $this->country = $user->country;
        $this->dob = $user->dob;
        $this->avatar = $user->profile_photo_url;
    }

    public function save()
    {
        $rules = (new UpdateRequest())->rules(optional($this)->id);
        $validatedData = $this->validate($rules);

        if ($this->authorize('update users')) {
            $response = $this->userService->update($this->id, $validatedData);
        }

        if (!$response['status']) {
            $this->toast()->error($response['error'])->send();
            return;
        } else {
            $this->toast()->success('Record updated successfully!')
                ->flash()
                ->send();

            return $this->redirect(route('admin.users.index'));
        }
    }

    public function render()
    {
        return view('pages.admin.user.edit');
    }
}
