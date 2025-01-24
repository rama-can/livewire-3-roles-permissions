<div>
    <x-seo-meta
        title="Rama Can"
    />
    <livewire:frontend.common.personal-desc />
    <livewire:frontend.subscription.subscribe />
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
