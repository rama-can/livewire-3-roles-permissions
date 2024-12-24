<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<?php echo '<?xml-stylesheet type="text/xsl" href="' . asset('vendor/atom.xsl') . '"?>'; ?>

<feed xmlns="http://www.w3.org/2005/Atom">
    <title>{{ $site['name'] }}</title>
    <link href="{{ route('rss') }}" rel="self"/>
    <link href="{{ route('home') }}" rel="alternate"/>
    <subtitle>{{ $site['description'] }}</subtitle>
    <updated>{{ $site['lastBuildDate'] }}</updated>
    <id>{{ route('home') }}</id>
    <author>
        <name>Rama Can</name>
        <email>ramacan@samudrait.com</email>
    </author>
    <rights type="text">Copyright © 2024 {"name"=>"Rama Can", "url"=>"{{ url('/') }}", "email"=>"ramacan@samudrait.com", "twitter"=>"_ramacan", "linkedin"=>"rama-can","github"=>"rama-can"}. All rights reserved.</rights>
    @foreach($posts as $post)

    <entry>
        <title>{{ $post->title }}</title>
        <link rel="alternate" href="{{ route('blogs.detail', $post->slug) }}" />
        <id>{{ route('blogs.detail', $post->slug) }}</id>
        <published>{{ $post->created_at->toAtomString() }}</published>
        <summary>{{ $post->description }}</summary>
        <content type="html">{{ $post->markdown }}</content>
    </entry>
    @endforeach

</feed>
