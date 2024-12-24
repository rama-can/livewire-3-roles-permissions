<x-front-layout background="bg-white dark:bg-gray-900">
    @php
        $title = View::yieldContent('title');
        $message = View::yieldContent('message');
    @endphp

<x-seo-meta
    title="{{ $title }}"
    description="{{ $message }}"
/>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <div class="max-w-2xl m-auto mt-16">

            <div class="text-center px-4">
                <div class="inline-flex mb-8">
                    <img class="dark:hidden" src="{{ asset('images/404-illustration.svg') }}" width="176" height="176" alt="404 illustration" />
                    <img class="hidden dark:block" src="{{ asset('images/404-illustration-dark.svg') }}" width="176" height="176" alt="404 illustration dark" />
                </div>
                <div class="mb-2 text-xl">@yield('title')</div>
                <div class="mb-6">@yield('message')</div>
                <a href="{{ route('home') }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">Back To Home</a>
            </div>

        </div>

    </div>
</x-front-layout>
