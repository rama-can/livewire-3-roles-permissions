<?php

namespace App\Modules\Admin\User;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;
use TallStackUi\Traits\Interactions;
use App\Services\User\UserServiceImplement;

class Index extends Component
{
    use Interactions;

    protected $userService;

    #[Locked]
    public $selectedId;
    public $dataTable = true;

    public function boot(UserServiceImplement $userService)
    {
        $this->authorize('read users');
        $this->userService = $userService;
    }

    #[Title('Users Management')]
    public function render()
    {
        return view('pages.admin.user.index')->with([
            'dataTable' => true
        ]);
    }

    #[On('delete-confirmation')]
    public function delete(string $id): void
    {
        $this->selectedId = $id;

        $this->dialog()
            ->question('Warning!', 'Are you sure you want to delete this user?')
            ->confirm('Confirm', 'confirmed', 'Confirmed Successfully')
            ->cancel('Cancel')
            ->send();
    }

    public function confirmed(): void
    {
        if ($this->selectedId && $this->authorize('delete users')) {
            $response = $this->userService->delete($this->selectedId);
            $this->dispatch('refreshDatatable');
            if ($response['status']) {
                $this->dialog()->success('Success', 'User deleted successfully')->send();
            } else {
                $this->dialog()->error('Error', 'Failed to delete user')->send();
            }

            // Reset selectedId
            $this->selectedId = null;
        }
    }
}
