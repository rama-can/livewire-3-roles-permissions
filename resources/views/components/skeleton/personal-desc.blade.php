<div>
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
                            <!-- Skeleton Title -->
                            <div class="h-8 bg-slate-300 dark:bg-slate-700 rounded w-3/4 mb-4 animate-pulse"></div>
                            <!-- Skeleton Subtitle -->
                            <div class="h-8 bg-slate-300 dark:bg-slate-700 rounded w-1/2 mb-4 animate-pulse"></div>
                            <!-- Skeleton Description -->
                            <div class="space-y-4">
                                <div class="h-4 bg-slate-300 dark:bg-slate-700 rounded w-full animate-pulse"></div>
                                <div class="h-4 bg-slate-300 dark:bg-slate-700 rounded w-full animate-pulse"></div>
                                <div class="h-4 bg-slate-300 dark:bg-slate-700 rounded w-3/4 animate-pulse"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
