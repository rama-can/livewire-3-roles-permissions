<?php

namespace App\Modules\Admin\User;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use App\Services\User\UserService;
use TallStackUi\Traits\Interactions;
use App\Http\Requests\User\StoreRequest;

class Create extends Component
{
    use Interactions;
    use WithFileUploads;

    public $username, $name, $email, $password, $phone_number = '', $zip = '', $country = '', $image, $dob, $role;

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

    // public function boot(UserServiceImplement $userService)
    // {
    //     $this->authorize('create users');
    //     $this->userService = $userService;
    // }

    public function save()
    {
        $rules = (new StoreRequest())->rules();
        $validatedData = $this->validate($rules);

        if ($this->authorize('create users')) {
            $response = $this->userService->create($validatedData);
        }

        if (!$response['status']) {
            $this->toast()->error($response['error'])->send();
            return;
        } else {
            $this->toast()->success('Record added successfully!')
                ->flash()
                ->send();

            return $this->redirect(route('admin.users.index'));
        }
    }

    public function render()
    {
        return view('pages.admin.user.create');
    }
}
