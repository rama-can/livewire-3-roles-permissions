<div>
    <x-seo-meta
        title="Blogs"
    />
    <section class="py-10">
        <div class="container px-6 mx-auto">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-slate-800 capitalize lg:text-3xl dark:text-slate-200">Blogs</h1>
                <p class="max-w-xl mx-auto mt-4 text-slate-800 dark:text-slate-200">
                    {{ __('frontend.frontend_blogs_section_description') }}
                </p>
            </div>
            <div class="grid lg:grid-cols-3 gap-6 mt-8">
                <!-- Blog Card -->
                @foreach ($this->getPostsProperty as $item)
                    <x-card-blog
                        :thumbnail="$item->thumbnailUrl"
                        :title="$item->title"
                        :description="$item->description"
                        :publishedAt="$item->created_at"
                        :url="route('blogs.detail', $item->slug)"
                    />
                @endforeach
            </div>
        </div>
    </section>
    {{-- <x-slot name="seo">
        <meta property="og:title" content="{{ $post->title }} | freek.dev"/>
        <meta property="og:description" content="{{ $post->plain_text_excerpt }}"/>
        <meta name="og:image" content="{{ url($post->getFirstMediaUrl('ogImage')) }}"/>

        @foreach($post->tags as $tag)
            <meta property="article:tag" content="{{ $tag->name }}"/>
        @endforeach

        <meta property="article:published_time" content="{{ optional($post->publish_date)->toIso8601String() }}"/>
        <meta property="og:updated_time" content="{{ $post->updated_at->toIso8601String() }}"/>
        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="twitter:description" content="{{ $post->plain_text_excerpt }}"/>
        <meta name="twitter:title" content="{{ $post->title }} | freek.dev"/>
        <meta name="twitter:site" content="@freekmurze"/>
        <meta name="twitter:image" content="{{ url($post->getFirstMediaUrl('ogImage')) }}"/>
        <meta name="twitter:creator" content="@freekmurze"/>
    </x-slot> --}}
</div>
