<?php

namespace App\Modules\Admin\Translation;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Config;
use Spatie\TranslationLoader\LanguageLine;

class Resource extends Component
{
    use Interactions;

    #[Locked]
    public $dataId = null;
    public $group = '';
    public $key = '';
    public $text = [];

    public $isModalOpen = false;

    public function rules(): array
    {
        return [
            'group' => 'required|string|max:255',
            'key' => ['required', 'regex:/^[a-zA-Z_]+$/'],
            'text' => 'required|array',
            'text.*' => 'required|string',
        ];
    }

    protected function messages()
    {
        return [
            'key.regex' => 'May only contain uppercase, lowercase, and underscore (_).',
        ];
    }

    public function mount()
    {
        $this->authorize('read translations');
        foreach (Config::get('app.languages') as $langLocale => $langName) {
            $this->text[$langLocale] = '';
        }
    }

    #[On('modal-form')]
    public function modalForm($id = null)
    {
        if ($id && $this->authorize('update translations')) {
            $lang = LanguageLine::findOrFail($id);
            $this->dataId = $lang->id;
            $this->group = $lang->group;
            $this->key = $lang->key;
            $this->text = $lang->text;
        } else {
            $this->authorize('create translations');
        }
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->authorize('create translations');
        $this->validate();
        try {
            LanguageLine::updateOrCreate(
                [
                    'group' => $this->group,
                    'key' => $this->key,
                ],
                [
                    'text' => $this->text,
                ]
            );
            $this->toast()->success('Translation saved successfully')->send();
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
            ->question('Warning!', 'Are you sure you want to delete this Translation?')
            ->confirm('Confirm', 'delete', 'Confirmed Successfully')
            ->cancel('Cancel')
            ->send();
    }

    public function delete(): void
    {
        $this->authorize('delete translations');
        try {
            $data = LanguageLine::findOrFail($this->dataId);
            $data->delete();
            $this->dispatch('refreshDatatable');
            $this->toast()->success('Translation deleted successfully!')->send();
            $this->dataId = null;
        } catch (\Throwable $th) {
            $this->toast()->error($th->getMessage())->send();
        }
    }

    public function resetModal()
    {
        $this->isModalOpen = false;
        $this->dataId = null;
        $this->group = null;
        $this->key = null;
        foreach ($this->text as $langLocale => $translationText) {
            $this->text[$langLocale] = '';
        }
        $this->reset();
        $this->resetValidation();
    }

    #[Title('Translation Management')]
    public function render()
    {
        return view('pages.admin.translation.resource');
    }
}
