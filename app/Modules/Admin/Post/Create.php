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

class Create extends Component
{
    use Interactions, WithFileUploads;

    public $title, $description, $content, $thumbnail, $thumbnail_caption, $category_id;
    public $categories;
    public $status = 'draft', $locale = 'id';

    protected $translationService;

    public function boot(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    public function mount()
    {
        $this->content = '';
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
        $validatedData = $this->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image',
            'thumbnail_caption' => 'required',
            'category_id' => 'required',
            'status' => 'required',
        ]);

        $manager = new ImageManager(Driver::class);

        try {
            DB::transaction(function () use ($validatedData, $manager) {
                $titleTranslate = $this->translationService->translate($validatedData['title']);
                $descTranslate = $this->translationService->translate($validatedData['description']);
                $contentTranslate = $this->translationService->translate($validatedData['content']);

                $image = $manager->read($validatedData['thumbnail']->getRealPath());

                // saving image in webp format
                $imageEncoded = $image->encode(new WebpEncoder(quality: 65));
                $path = 'images/blogs/' . uniqid() . date('YmdHis') . '.webp';
                Storage::disk('public')->put($path, $imageEncoded);

                $data = [
                    'user_id' => Auth::user()->id,
                    'category_id' => $validatedData['category_id'],
                    'status' => $validatedData['status'],
                    'thumbnail' => $path,
                    'thumbnail_caption' => $validatedData['thumbnail_caption'],
                    'id' => [
                        'title' => $validatedData['title'],
                        'slug' => Str::slug($validatedData['title']),
                        'description' => $validatedData['description'],
                        'content' => $validatedData['content']
                    ],
                    'en' => [
                        'title' => $titleTranslate,
                        'slug' => Str::slug($titleTranslate),
                        'description' => $descTranslate,
                        'content' => $contentTranslate
                    ],
                ];

                Post::create($data);
                $this->redirectRoute('admin.posts.index');
                $this->toast()->success('Post created successfully')->send();
            });
        } catch (\Exception $e) {
            $this->redirectIntended('/admin/posts/create');
            $this->toast()->success($e)->send();
        }
    }

    #[Title('Create Post')]
    public function render()
    {
        return view('pages.admin.post.create');
    }
}
