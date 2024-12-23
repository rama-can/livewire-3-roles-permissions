<div>
    <x-seo-meta
        title="Rama Can"
    />
    <section class="relative h-[90vh] flex flex-col justify-center bg-slate-100 dark:bg-slate-900 overflow-hidden">

        <div class="w-full max-w-6xl mx-auto px-4 md:px-6 py-24 mt-8 mb-5">
            <div>
                <!-- Illustration #1 -->
                <div class="absolute top-0 left-0 rotate-180 -translate-x-3/4 -scale-x-100 blur-3xl opacity-70 pointer-events-none" aria-hidden="true">
                    <img src="{{ asset('images/shape.svg') }}" class="max-w-none" width="852" height="582" alt="Illustration" />
                </div>

                <!-- Illustration #2 -->
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 blur-3xl opacity-70 pointer-events-none" aria-hidden="true">
                    <img src="{{ asset('images/shape.svg') }}" class="max-w-none" width="852" height="582" alt="Illustration" />
                </div>

                <!-- Particles animation -->
                <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
                    <canvas data-particle-animation wire:ignore></canvas>
                </div>

                <div class="container mx-auto px-4 py-16 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-16">
                        <div class="flex items-center justify-center order-1 lg:order-2">
                            <div class="relative w-40 h-40 sm:w-80 sm:h-80">
                                <img
                                    src="{{ asset('storage/'. themes('general', 'personal_image')) }}"
                                    alt="Rama Can"
                                    class="rounded-full"
                                    priority
                                />
                            </div>
                        </div>

                        <!-- Konten -->
                        <div class="flex flex-col justify-center order-2 lg:order-1 z-20">
                            <h1 class="text-3xl font-extrabold tracking-tight sm:text-5xl md:text-5xl">
                                <span class="block text-slate-800 dark:text-slate-100">
                                    {{ __('frontend.frontend_personal_section_title'); }}
                                </span>
                                <span
                                    class="block bg-clip-text text-transparent bg-[linear-gradient(to_right,theme(colors.indigo.500),theme(colors.indigo.400),theme(colors.sky.500),theme(colors.fuchsia.500),theme(colors.sky.500),theme(colors.indigo.100),theme(colors.indigo.400))] animate-gradient dark:bg-[linear-gradient(to_right,theme(colors.indigo.400),theme(colors.indigo.100),theme(colors.sky.400),theme(colors.fuchsia.400),theme(colors.sky.400),theme(colors.indigo.100),theme(colors.indigo.400))] bg-[length:200%_auto] animate-gradient"
                                >
                                    Full-Stack Developer
                                </span>
                            </h1>
                            <p class="mt-4 text-lg text-slate-800/80 dark:text-slate-200/80">
                                {{ __('frontend.frontend_personal_section_description'); }}
                            </p>
                            {{-- <div class="mt-8 flex flex-col sm:flex-row gap-4">
                                <a
                                    class="inline-flex justify-center whitespace-nowrap rounded-lg px-3.5 py-2.5 text-sm font-semibold text-slate-200 dark:text-slate-800 bg-gradient-to-r from-slate-800 to-slate-700 dark:from-slate-200 dark:to-slate-100 dark:hover:bg-slate-100 shadow focus:outline-none focus:ring focus:ring-slate-500/50 focus-visible:outline-none focus-visible:ring focus-visible:ring-slate-500/50 relative before:absolute before:inset-0 before:rounded-[inherit] before:bg-[linear-gradient(45deg,transparent_25%,theme(colors.white/.5)_50%,transparent_75%,transparent_100%)] dark:before:bg-[linear-gradient(45deg,transparent_25%,theme(colors.white)_50%,transparent_75%,transparent_100%)] before:bg-[length:250%_250%,100%_100%] before:bg-[position:200%_0,0_0] before:bg-no-repeat before:[transition:background-position_0s_ease] hover:before:bg-[position:-100%_0,0_0] hover:before:duration-[1500ms]"
                                    href="{{ asset('storage/'. themes('general', 'cv')) }}" download="ramacan-cv.pdf"
                                >
                                    {{ __('general.download_cv') }}
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- @livewire('frontend.subscription.subscribe') --}}
    <section>
        <div class="container px-6 py-16 mx-auto">
            <div class="text-start mb-5">
                <h1 class="font-caveat font-extrabold text-2xl sm:text-4xl md:text-4xl text-indigo-500">
                    {{ __('frontend.works_with_technologies') }}
                </h1>
            </div>
            <x-animate-infinite-scroll />
            <hr class="my-10 border-slate-200 dark:border-slate-700" />
        </div>
    </section>
    <section>
        <div class="container px-6 mx-auto">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-slate-800 capitalize lg:text-3xl dark:text-slate-200">Blogs</h1>
                <p class="max-w-xl mx-auto mt-4 text-slate-800 dark:text-slate-200">
                    {{ __('frontend.frontend_blogs_section_description') }}
                </p>
            </div>
            <div class="grid lg:grid-cols-3 gap-6 mt-8">
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

    @push('scripts')
    <script src="{{ asset('assets/particle-animation.js') }}"></script>
    @endpush
</div>
