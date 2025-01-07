<?xml version="1.0" encoding="UTF-8" ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ config('app.name') }}</title>
        <link>{{ url('/') }}</link>
        <description>Latest stories from {{ config('app.name') }}</description>
        <atom:link href="{{ route('rss.index') }}" rel="self" type="application/rss+xml" />
        @foreach($stories as $story)
            <item>
                <title>{{ $story->title }}</title>
                <link>{{ url("/story/{$story->id}") }}</link>
                <description>{{ $story->summary ?? $story->content }}</description>
                <pubDate>{{ $story->published_at->toRssString() }}</pubDate>
                <guid>{{ url("/story/{$story->id}") }}</guid>
            </item>
        @endforeach
    </channel>
</rss>
