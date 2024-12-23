<div>
    <x-seo-meta
        type="article"
        :title="$post->title"
        :description="$post->excerpt"
        :image="$post->thumbnailUrl"
        :url="route('blogs.detail', $post->slug)"
        :publishedAt="$post->created_at"
        :updatedAt="$post->updated_at"
        :author="$post->user->name"
        :category="$post->category->name"
    />
    <article>
        <header class="mt-10 mb-4 md:mb-0 w-full max-w-screen-md mx-auto relative roun" style="height: 24em;">
            <div class="absolute left-0 bottom-0 w-full h-full z-10"
              style="background-image: linear-gradient(180deg,transparent,rgba(0,0,0,.7));">
            </div>
            <img src="{{ $post->thumbnailUrl }}" loading="lazy" class="absolute left-0 top-0 w-full h-full z-0 object-cover rounded-lg" />
            <div class="p-4 absolute bottom-0 left-0 z-20">
                <a href="#"
                    class="px-4 py-1 bg-black text-gray-200 inline-flex items-center justify-center mb-2" rel="category">{{ $post->category->name ?? 'Unknown' }}</a>
                <h2 class="text-4xl font-semibold text-gray-100 leading-tight">
                    {{ $post->title }}
                </h2>
                <address class="flex mt-3 not-italic">
                    <img src="{{ $post->user()->profile_photo_url ?? 'https://avatars.githubusercontent.com/u/59125992' }}" alt="{{ $post->user->name ?? 'Unknown' }}"
                    class="h-10 w-10 rounded-full mr-2 object-cover" />
                    <div>
                        <p class="font-semibold text-gray-200 text-sm" rel="author">
                            {{ $post->user->name ?? 'Unknown' }}
                        </p>
                        <p class="font-semibold text-gray-400 text-xs">
                            <time pubdate datetime="2022-02-08" title="February 8th, 2022">
                                {{ $post->created_at->format('d M Y') }}
                            </time>
                        </p>
                    </div>
                </address>
            </div>
        </header>

        <div class="px-4 lg:px-0 mt-8 max-w-screen-md mx-auto text-lg leading-relaxed prose dark:prose-invert">
            {!! $post->markdown !!}
        </div>
    </article>
    @script
        <script>
            document.addEventListener('livewire:navigated', () => {
                const codeBlocks = document.querySelectorAll('pre code');
                const svgIcon = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                        <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                    </svg>
                `;

                const svgCopied = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l5 5l10 -10" />
                    </svg>
                `;

                codeBlocks.forEach((block) => {
                    // Buat tombol copy
                    const button = document.createElement('button');
                    button.className = 'copy-btn bg-gray-900 dark:bg-gray-500 text-white px-3 py-1 rounded text-sm absolute top-2 right-2 border border-gray-800 dark:border-gray-400 hidden group-hover:flex items-center gap-1';
                    button.innerHTML = `${svgIcon}<span>Copy</span>`;

                    // Bungkus pre > code untuk styling relatif
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative group';
                    const pre = block.parentNode;
                    pre.parentNode.replaceChild(wrapper, pre);
                    wrapper.appendChild(pre);
                    wrapper.appendChild(button);

                    // Event untuk menyalin teks
                    button.addEventListener('click', () => {
                        const code = block.innerText;
                        navigator.clipboard.writeText(code)
                            .then(() => {
                                button.innerHTML = `${svgCopied}<span>Copied!</span>`;
                                setTimeout(() => {
                                    button.innerHTML = `${svgIcon}<span>Copy</span>`;
                                }, 2000);
                            })
                            .catch((err) => {
                                console.error('Failed to copy text: ', err);
                            });
                    });
                });
            });
        </script>
    @endscript
</div>
