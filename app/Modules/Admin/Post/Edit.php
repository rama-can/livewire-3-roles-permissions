<?php

namespace App\Modules\Admin\Post;

use App\Models\Post;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use App\Services\Translation\TranslationService;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;

class Edit extends Component
{
    use Interactions, WithFileUploads;

    public $id, $title, $description, $content, $thumbnail, $thumbnail_caption, $category_id;
    public $categories, $datatranslations = [], $thumbnail_url;
    public $status = 'draft', $locale = 'id', $locales = ['en', 'id'];

    protected $translationService;

    public function boot(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    public function mount(string $id)
    {
        $post = Post::with('translations')->findOrFail($id);
        $this->id = $post->id;
        $this->category_id = $post->category_id;
        $this->status = $post->status;
        $this->thumbnail_caption = $post->thumbnail_caption;
        $this->thumbnail_url = $post->thumbnailUrl;
        foreach ($this->locales as $locale) {
            $translation = $post->translations()->where('locale', $locale)->first();
            $this->datatranslations[$locale] = [
                'title' => $translation->title ?? '',
                'description' => $translation->description ?? '',
                'content' => $translation->content ?? '',
            ];
        }

        $this->categories = Category::query()
            ->with(['parent.translations', 'children', 'translations'])
            ->get()
            ->map(fn($category) => [
                'id' => $category->id,
                'name' => $category->translations->first()->name ?? '',
            ]);
    }

    public function save()
    {
        $rules = [];
        foreach ($this->locales as $locale) {
            $rules["datatranslations.$locale.title"] = 'required|string|max:255';
            $rules["datatranslations.$locale.description"] = 'nullable|string';
            $rules["datatranslations.$locale.content"] = 'required|string';
        }
        $rules['thumbnail'] = 'nullable|image|max:1024|mimes:jpg,jpeg,png,webp,gif';
        $rules['thumbnail_caption'] = 'nullable|string|max:255';
        $rules['category_id'] = 'nullable|exists:categories,id';
        $rules['status'] = 'required|in:draft,published';

        Validator::make([
            'datatranslations' => $this->datatranslations,
            'category_id' => $this->category_id,
            'status' => $this->status,
        ], $rules)->validate();

        $manager = new ImageManager(Driver::class);

        $post = Post::findOrFail($this->id);
        try {
            DB::transaction(function () use ($post, $manager) {

                // Upload thumbnail jika ada
                $path = null;
                if ($this->thumbnail) {
                    $image = $manager->read($this->thumbnail->getRealPath());
                    $imageEncoded = $image->encode(new WebpEncoder(quality: 65));
                    $path = 'images/blogs/' . uniqid() . date('YmdHis') . '.webp';

                    Storage::disk('public')->put($path, $imageEncoded);
                    // delete old thumbnail if exists
                    if (!empty($post->thumbnail) && Storage::disk('public')->exists($post->thumbnail)) {
                        Storage::disk('public')->delete($post->thumbnail);
                    }
                }

                $post->fill([
                    'category_id' => $this->category_id,
                    'status' => $this->status,
                    'thumbnail' => $path ?? $post->thumbnail,
                    'thumbnail_caption' => $this->thumbnail_caption,
                ]);

                // Simpan terjemahan
                foreach ($this->datatranslations as $locale => $translation) {
                    $post->translateOrNew($locale)->fill([
                        'title' => $translation['title'],
                        'description' => $translation['description'],
                        'content' => $translation['content'],
                    ]);
                }

                $post->save();
                $this->redirectRoute('admin.posts.index');
                $this->toast()->success('Post updated successfully')->flash()->send();
            });
        } catch (\Exception $e) {
            $this->redirectIntended('/admin/posts/edit', ['id' => $this->id]);
            $this->toast()->success($e)->flash()->send();
        }
    }

    #[Title('Edit Post')]
    public function render()
    {
        return view('pages.admin.post.edit');
    }
}
