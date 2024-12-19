@props(['thumbnail', 'name', 'description', 'url', 'tags' => []])

<div class="flex flex-col bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
    <a href="{{ $url }}" class="group">
        <img
            class="object-cover h-48 w-full transition-opacity group-hover:opacity-90"
            src="{{ $thumbnail }}"
            alt="Project Image">
    </a>
    <div class="flex-1 flex flex-col p-6">
        <header class="mb-4">
            <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100 leading-snug">
                <a href="{{ $url }}" class="hover:text-teal-500 dark:hover:text-teal-400">
                    {{ $name }}
                </a>
            </h2>
        </header>
        <p class="text-sm text-slate-800 dark:text-slate-200 mb-4 line-clamp-3">
            {{ $description ?? '' }}
        </p>
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach ($tags as $tag)
                <span class="px-3 py-1 text-xs font-medium text-teal-600 bg-teal-100 dark:bg-teal-900 dark:text-teal-300 rounded-full">
                    #{{ $tag }}
                </span>
            @endforeach
        </div>
        <div class="flex justify-between items-center mt-auto">
            <a href="{{ $url }}"
                class="text-sm font-medium text-teal-600 dark:text-teal-400 hover:text-teal-500 dark:hover:text-teal-300 transition-all">
                {{ __('general.view_project') }} →
            </a>
        </div>
    </div>
</div>
