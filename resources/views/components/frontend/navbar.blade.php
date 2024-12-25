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

                    <hr class="w-px h-8 bg-gray-200 mr-2 ml-2 dark:bg-gray-700/60 border-none" />


                    <!-- Social Media Links -->
                    <div class="flex py-1">
                        <a href="https://github.com/rama-can" class="mx-1" aria-label="Github" target="_blank">
                            <svg class="text-gray-600 transition-colors duration-300 transform dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-300 w-5 h-5 fill-current" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.026 2C7.13295 1.99937 2.96183 5.54799 2.17842 10.3779C1.395 15.2079 4.23061 19.893 8.87302 21.439C9.37302 21.529 9.55202 21.222 9.55202 20.958C9.55202 20.721 9.54402 20.093 9.54102 19.258C6.76602 19.858 6.18002 17.92 6.18002 17.92C5.99733 17.317 5.60459 16.7993 5.07302 16.461C4.17302 15.842 5.14202 15.856 5.14202 15.856C5.78269 15.9438 6.34657 16.3235 6.66902 16.884C6.94195 17.3803 7.40177 17.747 7.94632 17.9026C8.49087 18.0583 9.07503 17.99 9.56902 17.713C9.61544 17.207 9.84055 16.7341 10.204 16.379C7.99002 16.128 5.66202 15.272 5.66202 11.449C5.64973 10.4602 6.01691 9.5043 6.68802 8.778C6.38437 7.91731 6.42013 6.97325 6.78802 6.138C6.78802 6.138 7.62502 5.869 9.53002 7.159C11.1639 6.71101 12.8882 6.71101 14.522 7.159C16.428 5.868 17.264 6.138 17.264 6.138C17.6336 6.97286 17.6694 7.91757 17.364 8.778C18.0376 9.50423 18.4045 10.4626 18.388 11.453C18.388 15.286 16.058 16.128 13.836 16.375C14.3153 16.8651 14.5612 17.5373 14.511 18.221C14.511 19.555 14.499 20.631 14.499 20.958C14.499 21.225 14.677 21.535 15.186 21.437C19.8265 19.8884 22.6591 15.203 21.874 10.3743C21.089 5.54565 16.9181 1.99888 12.026 2Z">
                                </path>
                            </svg>
                        </a>
                        <a href="https://x.com/_ramacan" class="mx-1" aria-label="Twitter" target="_blank">
                            <svg class="text-gray-600 transition-colors duration-300 transform dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-300  w-5 h-5 fill-current" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                <path d="M42,12.429c-1.323,0.586-2.746,0.977-4.247,1.162c1.526-0.906,2.7-2.351,3.251-4.058c-1.428,0.837-3.01,1.452-4.693,1.776C34.967,9.884,33.05,9,30.926,9c-4.08,0-7.387,3.278-7.387,7.32c0,0.572,0.067,1.129,0.193,1.67c-6.138-0.308-11.582-3.226-15.224-7.654c-0.64,1.082-1,2.349-1,3.686c0,2.541,1.301,4.778,3.285,6.096c-1.211-0.037-2.351-0.374-3.349-0.914c0,0.022,0,0.055,0,0.086c0,3.551,2.547,6.508,5.923,7.181c-0.617,0.169-1.269,0.263-1.941,0.263c-0.477,0-0.942-0.054-1.392-0.135c0.94,2.902,3.667,5.023,6.898,5.086c-2.528,1.96-5.712,3.134-9.174,3.134c-0.598,0-1.183-0.034-1.761-0.104C9.268,36.786,13.152,38,17.321,38c13.585,0,21.017-11.156,21.017-20.834c0-0.317-0.01-0.633-0.025-0.945C39.763,15.197,41.013,13.905,42,12.429"></path>
                                </svg>

                        </a>
                        <a href="https://linkedin.com/in/rama-can" class="mx-1" aria-label="LinkedIn" target="_blank">
                            <svg class="text-gray-600 transition-colors duration-300 transform dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-300  w-5 h-5 fill-current" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                <path d="M42,37c0,2.762-2.238,5-5,5H11c-2.761,0-5-2.238-5-5V11c0-2.762,2.239-5,5-5h26c2.762,0,5,2.238,5,5V37z"></path><path fill="black" d="M12 19H17V36H12zM14.485 17h-.028C12.965 17 12 15.888 12 14.499 12 13.08 12.995 12 14.514 12c1.521 0 2.458 1.08 2.486 2.499C17 15.887 16.035 17 14.485 17zM36 36h-5v-9.099c0-2.198-1.225-3.698-3.192-3.698-1.501 0-2.313 1.012-2.707 1.99C24.957 25.543 25 26.511 25 27v9h-5V19h5v2.616C25.721 20.5 26.85 19 29.738 19c3.578 0 6.261 2.25 6.261 7.274L36 36 36 36z"></path>
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/_ramacan" class="mx-1" aria-label="Instagram" target="_blank">
                            <svg class="text-gray-600 transition-colors duration-300 transform dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-300  w-5 h-5 fill-current" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M16,4H8C5.791,4,4,5.791,4,8v8c0,2.209,1.791,4,4,4h8c2.209,0,4-1.791,4-4V8C20,5.791,18.209,4,16,4z M12,16c-2.209,0-4-1.791-4-4c0-2.209,1.791-4,4-4s4,1.791,4,4C16,14.209,14.209,16,12,16z" opacity=".3"></path><path d="M16,3H8C5.243,3,3,5.243,3,8v8c0,2.757,2.243,5,5,5h8c2.757,0,5-2.243,5-5V8C21,5.243,18.757,3,16,3z M19,16c0,1.654-1.346,3-3,3H8c-1.654,0-3-1.346-3-3V8c0-1.654,1.346-3,3-3h8c1.654,0,3,1.346,3,3V16z"></path><path d="M12 7c-2.757 0-5 2.243-5 5s2.243 5 5 5 5-2.243 5-5S14.757 7 12 7zM12 15c-1.654 0-3-1.346-3-3s1.346-3 3-3 3 1.346 3 3S13.654 15 12 15zM17 6A1 1 0 1 0 17 8 1 1 0 1 0 17 6z"></path>
                                </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</navbar>
