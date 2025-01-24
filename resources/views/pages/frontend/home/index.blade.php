<div>
    <x-seo-meta
        title="Rama Can"
    />
    <section class="relative h-[88vh] flex flex-col justify-center bg-slate-100 dark:bg-slate-900 overflow-hidden">
        <div class="w-full max-w-6xl mx-auto px-4 md:px-6 py-24 mt-8 mb-5">
            <div>
                <!-- Illustration #1 -->
                <div class="absolute top-0 left-0 rotate-180 -translate-x-3/4 -scale-x-100 blur-3xl opacity-70 pointer-events-none" aria-hidden="true">
                    <img src="{{ asset('images/shape.svg') }}" loading="lazy" class="max-w-none" width="852" height="582" alt="Illustration" />
                </div>

                <!-- Illustration #2 -->
                <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 blur-3xl opacity-70 pointer-events-none" aria-hidden="true">
                    <img src="{{ asset('images/shape.svg') }}" loading="lazy" class="max-w-none" width="852" height="582" alt="Illustration" />
                </div>

                <!-- Particles animation -->
                <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
                    <canvas data-particle-animation wire:ignore></canvas>
                </div>
                <div class="container mx-auto px-4 py-16 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-1 lg:gap-16">
                        <!-- Content -->
                        <div class="flex flex-col justify-center order-2 lg:order-1 z-20">
                            <h1 class="text-3xl font-extrabold tracking-tight sm:text-5xl md:text-5xl">
                                <span class="block text-slate-800 dark:text-slate-200">
                                    {{ __('frontend.frontend_personal_section_title'); }}
                                </span>
                                <span class="block bg-clip-text text-transparent bg-[linear-gradient(to_right,theme(colors.indigo.500),theme(colors.indigo.400),theme(colors.sky.500),theme(colors.fuchsia.500),theme(colors.sky.500),theme(colors.indigo.100),theme(colors.indigo.400))] animate-gradient dark:bg-[linear-gradient(to_right,theme(colors.indigo.500),theme(colors.indigo.300),theme(colors.sky.400),theme(colors.fuchsia.300),theme(colors.sky.400),theme(colors.indigo.100),theme(colors.indigo.400))] bg-[length:90%_auto] animate-gradient">
                                    Full-Stack Developer
                                </span>
                            </h1>
                            <p class="mt-4 text-lg text-slate-800/80 dark:text-slate-200/80">
                                {{ __('frontend.frontend_personal_section_description'); }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @livewire('frontend.subscription.subscribe')
    <section>
        <div class="container px-6 mx-auto mt-5">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-slate-800 capitalize lg:text-3xl dark:text-slate-200">Blogs</h1>
                <p class="max-w-xl mx-auto mt-4 text-slate-800 dark:text-slate-200">
                    {{ __('frontend.frontend_blogs_section_description') }}
                </p>
            </div>
            <!-- List Blog Card -->
            <livewire:frontend.common.list-blog lazy />
        </div>
    </section>

    @push('scripts')
    <script src="{{ asset('assets/particle-animation.js') }}" defer></script>
    @endpush
</div>
