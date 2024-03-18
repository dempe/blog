{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title>Chris Dempewolf's Blog</title>
        <link>{{ url('/') }}</link>
        <atom:link href="https://chrisdempewolf.com/feed.rss" rel="self" type="application/rss+xml"/>
        <description>A personal blog by Chris Dempewolf about science, technology, and computation.</description>
        <language>en</language>

        @foreach($posts as $post)
            <item>
                <title>{{ $post->title }}</title>
                <link>{{ url('/posts/' . $post->slug) }}</link>
                <description>{{ Str::limit($post->body, 100) }}</description>
                <content:encoded><![CDATA[{!! $post->body !!}]]></content:encoded>
                <pubDate>{{ $post->created_at->toRssString() }}</pubDate>
                <guid>{{ url('/posts/' . $post->slug) }}</guid>
            </item>
        @endforeach
    </channel>
</rss>
