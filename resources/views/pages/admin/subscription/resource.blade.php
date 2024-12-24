<div>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- breadcrumb -->
        <x-breadcrumb :items="[
            ['url' => route('admin.dashboard'), 'label' => 'Dashboard'],
            ['label' => 'Subscriptions']
        ]" />
        <!-- Actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Subscriptions ({{ $count }})</h1>
            </div>

        </div>

        <!-- Content -->
        <div>
            <div class="overflow-x-auto">
                <livewire:admin.subscription.table />
            </div>
        </div>
    </div>
</div>
