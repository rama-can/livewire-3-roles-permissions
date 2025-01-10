<div>
    <div class="grid lg:grid-cols-3 gap-6 mt-8">
        @for ($i = 0; $i < 3; $i++)
        <div class="flex flex-col bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl overflow-hidden animate-pulse">
            <div class="h-48 bg-slate-200 dark:bg-slate-700"></div>
            <div class="flex-1 flex flex-col p-6">
                <header class="mb-4">
                    <div class="h-6 bg-slate-200 dark:bg-slate-700 rounded"></div>
                </header>
                <div class="flex-1 space-y-4 mb-2">
                    <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded"></div>
                    <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded"></div>
                </div>
                <div class="flex justify-between items-center mt-auto">
                    <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded w-1/4"></div>
                    <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded w-1/4"></div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
