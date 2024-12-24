<?php

namespace App\Modules\Admin\Setting;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;

class Resource extends Component
{
    use WithFileUploads, Interactions;

    #[Locked]
    public $dataId;
    public $isModalOpen = false;
    public $group, $key, $value, $type;
    public $fileUpload;
    public $attr;

    public function rules(): array
    {
        return [
            'group' => 'required',
            'type' => 'required',
            'key' => 'required',
            'key' => 'required',
            'fileUpload' => $this->type === 'image' || $this->type === 'file' ? 'nullable|file|max:2048' : 'nullable',
        ];
    }

    public function loadSetting($dataId)
    {
        $setting = Setting::find($dataId);

        if ($setting) {
            $this->dataId = $setting->id;
            $this->group = $setting->group;
            $this->type = $setting->type;
            $this->key = $setting->key;
            $this->value = $setting->value;
            $this->attr = json_encode($setting->attributes);
        }
    }

    #[On('modal-form')]
    public function modalForm($id = null)
    {
        if ($id && $this->authorize('update permissions')) {
            $this->loadSetting($id);
        } else {
            $this->authorize('create permissions');
        }
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();
        // dd($this->validate());
        $setting = $this->dataId ? Setting::find($this->dataId) : new Setting();

        $setting->group = $this->group;
        $setting->key = $this->key;

        // Handle file/image upload if applicable
        if (in_array($this->type, ['image', 'file']) && $this->fileUpload instanceof UploadedFile) {
            // Delete old file if exists and editing
            if ($this->dataId && $setting->value) {
                Storage::disk('public')->delete($setting->value);
            }

            $manager = new ImageManager(Driver::class);

            // Handle image uploads specifically
            if ($this->type === 'image') {
                $image = $manager->read($this->fileUpload->getRealPath());
                $imageEncoded = $image->encode(new WebpEncoder(quality: 65)); // Encode to WebP with quality 65
                $path = 'images/' . uniqid() . date('YmdHis') . '.webp';
                Storage::disk('public')->put($path, $imageEncoded);
            } else {
                // Handle file uploads
                $directory = 'files';
                $path = $this->fileUpload->store($directory, 'public');
            }

            // Update the setting value
            $setting->value = $path;
        } else {
            // Handle non-file types
            $setting->value = $this->value;
        }

        if ($this->attr && !$this->isValidJson($this->attr)) {
            $this->toast()->success('The JSON format is invalid.')->send();
            return;
        }

        $attributesArray = $this->attr ? json_decode($this->attr, true) : null;
        $setting->attributes = $attributesArray;

        $setting->type = $this->type;

        $setting->save();

        $this->toast()->success('Setting saved successfully.')->send();
        $this->dispatch('refreshDatatable');
        $this->resetModal();
    }

    public function formatJson()
    {
        if ($this->isValidJson($this->attr)) {
            $this->attr = json_encode(json_decode($this->attr, true), JSON_PRETTY_PRINT);
        }
    }

    public function isValidJson($json)
    {
        if (is_null($json) || $json === '') {
            return false;
        }

        json_decode($json);
        return json_last_error() === JSON_ERROR_NONE;
    }


    public function resetModal()
    {
        $this->isModalOpen = false;
        $this->dataId = null;
        $this->reset();
        $this->resetValidation();
    }

    #[Title('Theme Setting')]
    public function render()
    {
        return view('pages.admin.setting.resource');
    }
}
