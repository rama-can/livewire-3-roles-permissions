<?php

namespace App\Modules\Admin\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Resource extends Component
{
    use Interactions, WithFileUploads;

    public $datatranslations = [], $locales = ['en', 'id'], $isModalOpen = false, $thumbnailUrl;
    public $categories, $parentCategories, $categoryId, $parentId, $status = 'draft', $thumbnail = null;

    public function mount()
    {
        $this->authorize('read categories');
        // dd($this->tab);
        $this->locales = supportedLocales();
        $this->loadParentCategories();
    }

    protected function loadParentCategories()
    {
        $this->parentCategories = Category::whereNull('parent_id')
            ->with(['translations' => fn($query) => $query->where('locale', currentLocale())])
            ->get()
            ->map(fn($category) => [
                'id' => $category->id,
                'name' => $category->translations->first()->name ?? '',
            ]);
        $this->parentCategories->prepend([
            'id' => null,
            'name' => '-- Choose Parent Category --',
        ]);
    }

    #[On('modal-form')]
    public function modalForm($id = null)
    {
        $this->resetFields();
        if ($id) {
            $category = Category::with('translations')->findOrFail($id);
            $this->fillCategoryData($category);
        }
        $this->isModalOpen = true;
    }

    private function fillCategoryData($category)
    {
        $this->categoryId = $category->id;
        $this->parentId = $category->parent_id;
        $this->status = $category->status;
        $this->thumbnailUrl = Storage::url($category->thumbnail);
        foreach ($this->locales as $locale) {
            $translation = $category->translations()->where('locale', $locale)->first();
            $this->datatranslations[$locale] = [
                'name' => $translation->name ?? '',
                'slug' => $translation->slug ?? '',
                'description' => $translation->description ?? '',
            ];
        }
    }

    public function save()
    {
        $rules = [];
        foreach ($this->locales as $locale) {
            $rules["datatranslations.$locale.name"] = 'required|string|max:255';
            $rules["datatranslations.$locale.description"] = 'nullable|string';
        }
        $rules['thumbnail'] = 'nullable|image|max:1024|mimes:jpg,jpeg,png,webp,gif';
        $rules['parentId'] = 'nullable|exists:categories,id';
        $rules['status'] = 'required|in:draft,published';

        Validator::make([
            'datatranslations' => $this->datatranslations,
            'parentId' => $this->parentId,
            'status' => $this->status,
        ], $rules)->validate();

        // Proses penyimpanan data setelah validasi berhasil
        DB::transaction(function () {
            // Proses penyimpanan data setelah validasi berhasil
            $category = $this->categoryId ? Category::findOrFail($this->categoryId) : new Category();
            if ($this->thumbnail) {
                // delete old thumbnail if exists
                if (!empty($category->thumbnail) && Storage::disk('public')->exists($category->thumbnail)) {
                    Storage::disk('public')->delete($category->thumbnail);
                }

                $path = $this->thumbnail->store('images/categories', 'public');
            }
            $category->fill([
                'parent_id' => $this->parentId,
                'status' => $this->status,
                'thumbnail' => $path ?? $category->thumbnail,
            ]);

            // Simpan terjemahan
            foreach ($this->datatranslations as $locale => $translation) {
                $category->translateOrNew($locale)->fill([
                    'name' => $translation['name'],
                    'description' => $translation['description'],
                ]);
            }

            // Simpan kategori beserta terjemahan
            $category->save();
        });

        $this->toast()->success('Category saved successfully')->send();
        $this->resetFields();
        $this->dispatch('refreshDatatable');
    }

    #[On('delete-confirmation')]
    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            // $this->deleteCategory($id);
            $category = Category::findOrFail($id);
            $category->delete();
            $category->deleteTranslations();
        });
        $this->toast()->success('Category deleted successfully')->send();
        $this->dispatch('refreshDatatable');
    }

    public function resetFields()
    {
        $this->categoryId = null;
        $this->parentId = null;
        $this->status = 'draft';
        $this->isModalOpen = false;
        $this->resetErrorBag();
        $this->datatranslations = [];
    }

    #[Title('Categories')]
    public function render()
    {
        return view('pages.admin.category.resource');
    }
}
