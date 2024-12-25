<footer class="bg-slate-100 shadow dark:bg-slate-900 pattern mt-10">
    <div class="container px-6 py-10 mx-auto">
        <div class="flex flex-col items-center text-center">
            <a href="{{ route('home') }}">
                <x-logo width="84" height="84" />
            </a>

            <p class="max-w-xl mx-auto mt-4 text-slate-600 dark:text-slate-400">
                “{{ __('general.hr_Ahmad') }}”
            </p>
        </div>

        <hr class="my-10 border-slate-200 dark:border-slate-700" />

        <div class="flex flex-col items-center sm:flex-row sm:justify-between">
            <p class="text-sm text-slate-500 dark:text-slate-400">© {{ date('Y') }} Rama Can. All Rights Reserved.</p>

            <div class="flex mt-3 space-x-4 sm:mt-0">
            @php
                $menus = json_decode(themes('frontend', 'menus'), true);
            @endphp

            @foreach ($menus as $menu)
                @if ($menu['is_active'])
                    <a href="{{ route($menu['route_name']) }}" wire:navigate class="text-sm text-slate-500 transition hover:text-slate-700 dark:text-slate-300 dark:hover:text-slate-100" aria-label="Blog">{{ $menu['label'] }}</a>
                @endif
            @endforeach
            </div>
        </div>
    </div>
</footer>
