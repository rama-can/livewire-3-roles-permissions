<navbar x-data="{ isOpen: false }" class="sticky top-0 bg-white bg-opacity-90 dark:bg-[#182235] dark:bg-opacity-90 border-b border-slate-200 dark:border-slate-700 z-30 lg:static lg:bg-opacity-100">

    <div class="container px-6 py-4 mx-auto">
        <div class="lg:flex lg:items-center">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" wire:navigate>
                    <x-logo width="42" height="42" />
                </a>

                <!-- Mobile menu button -->
                <div class="flex lg:hidden">
                    <button x-cloak @click="isOpen = !isOpen" type="button" class="text-slate-500 dark:text-slate-200 hover:text-slate-600 dark:hover:text-slate-400 focus:outline-none focus:text-slate-600 dark:focus:text-slate-400" aria-label="toggle menu">
                        <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                        </svg>

                        <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-cloak :class="[isOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']" class="absolute inset-x-0 flex-1 w-full px-6 py-4 transition-all duration-300 ease-in-out bg-white bg-opacity-90 dark:bg-[#182235] dark:bg-opacity-90 lg:bg-opacity-100 z-30 lg:mt-0 lg:p-0 lg:top-0 lg:relative lg:bg-transparent lg:w-auto lg:opacity-100 lg:translate-x-0 lg:flex lg:items-center lg:justify-between">
                <div class="flex flex-col text-slate-600 capitalize dark:text-slate-300 lg:flex lg:px-16 lg:-mx-4 lg:flex-row lg:items-center">
                    @php
                        $menus = json_decode(themes('frontend', 'menus'), true);
                    @endphp

                    @foreach ($menus as $menu)
                        @if ($menu['is_active'])
                            <a href="{{ route($menu['route_name']) }}" wire:navigate class="mt-2 transition-colors duration-300 transform lg:mt-0 lg:mx-4 hover:text-slate-900 dark:hover:text-slate-100">
                                {{ $menu['label'] }}
                            </a>
                        @endif
                    @endforeach
                    {{-- <div class="relative mt-4 lg:mt-0 lg:mx-4">
                        <x-modal-search />
                    </div> --}}
                </div>

                <div class="flex justify-center mt-6 lg:flex lg:mt-0 lg:-mx-2">

                    <div x-data="{ isOpen: false, openedWithKeyboard: false }" class="relative" @keydown.esc.window="isOpen = false, openedWithKeyboard = false">
                        <!-- Toggle Button -->
                        <button type="button" @click="isOpen = !isOpen" class="flex items-center justify-center cursor-pointer w-8 h-8 hover:bg-gray-100 lg:hover:bg-gray-200 dark:hover:bg-gray-700 dark:lg:hover:bg-gray-700 rounded-full text-gray-500/80 dark:text-gray-400/80" aria-haspopup="true" :aria-expanded="isOpen || openedWithKeyboard">
                            <span>{{ strtoupper(app()->getLocale()) }}</span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-cloak x-show="isOpen || openedWithKeyboard" x-transition x-trap="openedWithKeyboard" @click.outside="isOpen = false, openedWithKeyboard = false" class="absolute top-12 left-0 w-full min-w-[12rem] flex-col overflow-hidden rounded-md border border-slate-300 bg-slate-50 py-2 shadow-lg dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a href="{{ isset($currentPost) && $currentPost->hasTranslation($localeCode)
                                    ? LaravelLocalization::getLocalizedURL($localeCode, route('blogs.detail', ['slug' => $currentPost->translate($localeCode)->slug]), [], true)
                                    : LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" wire:navigate
                                    class="block px-4 py-2 text-sm hover:bg-gray-800/5 hover:text-gray-800 focus-visible:bg-gray-900/10 focus-visible:text-gray-900 text-gray-500/80 dark:text-gray-400 dark:hover:bg-gray-50/5 dark:hover:text-white dark:focus-visible:bg-gray-50/10 dark:focus-visible:text-white">
                                    {{ ucfirst($properties['native']) }} <!-- Show language code -->
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <x-theme-toggle class="mx-2" />

                    {{-- <a href="#" class="mx-2 text-gray-600 transition-colors duration-300 transform dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-300" aria-label="Github">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12.026 2C7.13295 1.99937 2.96183 5.54799 2.17842 10.3779C1.395 15.2079 4.23061 19.893 8.87302 21.439C9.37302 21.529 9.55202 21.222 9.55202 20.958C9.55202 20.721 9.54402 20.093 9.54102 19.258C6.76602 19.858 6.18002 17.92 6.18002 17.92C5.99733 17.317 5.60459 16.7993 5.07302 16.461C4.17302 15.842 5.14202 15.856 5.14202 15.856C5.78269 15.9438 6.34657 16.3235 6.66902 16.884C6.94195 17.3803 7.40177 17.747 7.94632 17.9026C8.49087 18.0583 9.07503 17.99 9.56902 17.713C9.61544 17.207 9.84055 16.7341 10.204 16.379C7.99002 16.128 5.66202 15.272 5.66202 11.449C5.64973 10.4602 6.01691 9.5043 6.68802 8.778C6.38437 7.91731 6.42013 6.97325 6.78802 6.138C6.78802 6.138 7.62502 5.869 9.53002 7.159C11.1639 6.71101 12.8882 6.71101 14.522 7.159C16.428 5.868 17.264 6.138 17.264 6.138C17.6336 6.97286 17.6694 7.91757 17.364 8.778C18.0376 9.50423 18.4045 10.4626 18.388 11.453C18.388 15.286 16.058 16.128 13.836 16.375C14.3153 16.8651 14.5612 17.5373 14.511 18.221C14.511 19.555 14.499 20.631 14.499 20.958C14.499 21.225 14.677 21.535 15.186 21.437C19.8265 19.8884 22.6591 15.203 21.874 10.3743C21.089 5.54565 16.9181 1.99888 12.026 2Z">
                            </path>
                        </svg>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
</navbar>
