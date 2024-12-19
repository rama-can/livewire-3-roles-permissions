<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        @foreach ($items as $item)
            <li class="inline-flex items-center">
                @if (!$loop->last)
                    <a href="{{ $item['url'] }}" wire:navigate
                        class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white inline-flex items-center">
                        @if ($loop->first)
                            <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 2a1 1 0 00-.707.293l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h3a1 1 0 001-1v-3h2v3a1 1 0 001 1h3a1 1 0 001-1v-6.586l1.293 1.293a1 1 0 001.414-1.414l-7-7A1 1 0 0010 2z" />
                            </svg>
                        @endif
                        {{ $item['label'] }}
                    </a>
                @else
                    {{-- <span class="ml-1 text-gray-700 dark:text-gray-300 md:ml-2">{{ $item['label'] }}</span> --}}
                    {{ $item['label'] }}
                @endif
            </li>
            @if (!$loop->last)
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
