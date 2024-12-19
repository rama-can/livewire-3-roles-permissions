@props(['thumbnail', 'title', 'description', 'url', 'publishedAt' => now()])

<div class="flex flex-col bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
    <a href="{{ $url }}" class="group" wire:navigate.hover>
        <img
            class="object-cover h-48 w-full transition-opacity group-hover:opacity-90"
            src="{{ $thumbnail }}"
            alt="Blog Image">
    </a>
    <div class="flex-1 flex flex-col p-6">
        <header class="mb-4">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 leading-snug">
                <a href="{{ $url }}" wire:navigate.hover class=" hover:text-indigo-500 dark:hover:text-indigo-400">
                    {{ $title }}
                </a>
            </h2>
        </header>
        <p class="text-sm text-slate-800 dark:text-slate-200 mb-4 line-clamp-2">
            {{ $description ?? '' }}
        </p>
        <div class="flex justify-between items-center mt-auto">
            <!-- Date -->
            <p class="text-xs text-slate-600 dark:text-slate-400">
                {{ \Carbon\Carbon::parse($publishedAt)->format('M d, Y') }}
                {{-- {{ \Carbon\Carbon::parse($publishedAt)->diffForHumans() }} --}}
            </p>

            <!-- Read More Link -->
            <a href="{{ $url }}" wire:navigate.hover
                class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-all">
                {{ __('general.read_more') }} →
            </a>
        </div>
    </div>
</div>
