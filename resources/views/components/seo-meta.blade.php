@props([
    'type' => 'website',
    'title' => null,
    'description' => __('general.site_description'),
    'image' => asset('storage/'. themes('general', 'site_thumbnail')),
    'url' => null,
    'publishedAt' => null,
    'updatedAt' => null,
    'author' => null,
    'category' => null,
    'tags' => null,
    'keywords' => null,
    'canonical' => null,
])
<x-slot name="seo">
    <!-- Primary Meta Tags -->
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="author" content="{{ themes('general', 'site_name') }}">
    <link rel="canonical" href="{{ url()->current() }}" />
    <!--Open Graph-->
    <meta property="og:type" content="{{ $type === 'article' ? 'article' : 'website' }}" />
    <meta property="og:image" content="{{ $image }}"/>
    <meta property="og:title" content="{{ $title }}"/>
    <meta property="og:description" content="{{ $description }}"/>
    <meta property="og:url" content="{{ $url ?? url()->current() }}" />
    <meta property="og:site_name" content="{{ themes('general', 'site_name') }}" />
    @if($type === 'article')
        <meta property="article:published_time" content="{{ optional($publishedAt)->toIso8601String() }}" />
        <meta property="article:modified_time" content="{{ optional($updatedAt)->toIso8601String() }}" />
        @if($category)
            <meta property="article:section" content="{{ $category }}" />
        @endif
        @if($tags)
            @foreach(explode(',', $tags) as $tag)
                <meta property="article:tag" content="{{ $tag }}" />
            @endforeach
        @endif
    @endif
    <!--Twitter-->
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="{{ $title }}"/>
    <meta name="twitter:description" content="{{ $description }}"/>
    <meta name="twitter:image" content="{{ $image }}"/>
    <meta name="twitter:site" content="@_ramacan"/>
    <meta name="twitter:creator" content="@_ramacan"/>
    @if($type === 'article')
    {{-- <link rel="shortlink" href=""> --}}
    <!--Schema.org-->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "BlogPosting",
            "author": {
                "@type": "Person",
                "name": "{{ themes('general', 'site_name') }}",
                "alternateName": ["Rama Can", "ramacan", "_ramacan", "vid ramadhan", "david ramadhan", "ramadhan"],
                "url": "{{ themes('general', 'site_url') }}",
                "sameAs": [
                    "https://www.linkedin.com/in/rama-can",
                    "https://github.com/rama-can",
                    "https://twitter.com/_ramacan",
                    "https://www.instagram.com/_ramacan",
                    "https://www.facebook.com/ramacan.dev"
                ]
            },
            "headline": "{{ $title }}",
            "url": "{{ $url ?? url()->current() }}",
            "datePublished": "{{ optional($publishedAt)->toIso8601String() }}",
            "dateModified": "{{ $updatedAt->toIso8601String() }}",
            "image": {
                "@type": "ImageObject",
                "url": "{{ $image }}",
                "width": 800,
                "height": 600
            },
            "description": "{{ $description }}",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ themes('general', 'site_url') }}"
            }
        }
    </script>
    @else
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "publisher": {
                "@type": "Person",
                "name": "{{ themes('general', 'site_name') }}",
                "alternateName": ["Rama Can", "ramacan", "_ramacan", "vid ramadhan", "david ramadhan", "ramadhan"],
                "url": "{{ themes('general', 'site_url') }}",
                "sameAs": [
                    "https://www.linkedin.com/in/rama-can",
                    "https://github.com/rama-can",
                    "https://twitter.com/_ramacan",
                    "https://www.instagram.com/_ramacan",
                    "https://www.facebook.com/ramacan.dev"
                ]
            },
            "url": "{{ $url ?? url()->current() }}",
            "headline": "{{ $title }}",
            "description": "{{ $description }}",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ themes('general', 'site_url') }}"
            }
        }
    </script>
    @endif
    <!-- RSS -->
    <link type="application/atom+xml" rel="alternate" href="{{ route('rss') }}" title="{{ themes('general', 'site_name') }}">
</x-slot>
