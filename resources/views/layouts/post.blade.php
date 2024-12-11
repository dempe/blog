@extends('layouts.layout')

@section('title')
    {{ $post->title }}
@endsection

@section('subhead')
    {!! $post->subhead  !!}
@endsection

@section('metadata')
    <tr>
        <td>Published:&nbsp;&nbsp;</td>
{{--        <td>{{ $post->created_at->format('Y-m-d H:i') }}</td>--}}
        <td>{{ $post->created_at->format('Y-m-d') }}</td>
    </tr>
    @if(isset($post->updated_at))
        <tr>
            <td>Updated:&nbsp;&nbsp;</td>
            <td>
                {{ $post->updated_at->format('Y-m-d') }}
            </td>
        </tr>
    @endif
    <tr>
        <td>Words:</td>
        <td>{{ $post->wc }}</td>
    </tr>
    <tr>
        <td>Tags:&nbsp;&nbsp;</td>
        <td>
            @foreach($tags as $tag)
                <a class="no-underline" href="/tags/{{ $tag }}">#{{ $tag }}</a>&nbsp;
            @endforeach
        </td>
    </tr>
@endsection

@section('toc')
    @if(isset($post->toc))
        {!! $post->toc !!}
    @endif
@endsection

@section('content')
    {!! $post->body !!}
@endsection

@section('prev-next')
    <nav class="hidden text-xl md:flex md:flex-row justify-between border-t-4 pt-8">
        <div>
            @if(isset($post->prev))
                <a class="no-underline" href="/posts/{{$post->prev->slug}}">&larr; {{$post->prev->title}}</a>
            @endif
        </div>
        <div>
            @if(isset($post->next))
                <a class="no-underline" href="/posts/{{$post->next->slug}}">{{$post->next->title}} &rarr;</a>
            @endif
        </div>
    </nav>

    <div class="flex flex-col items-center justify-center md:hidden">
        @if(isset($post->prev))
            <div class="mb-4 mx-auto"><a class="no-underline"
                                         href="/posts/{{$post->prev->slug}}">&larr; {{$post->prev->title}}</a></div>
        @endif
        @if(isset($post->next))
            <div class="mb-4 mx-auto"><a class="no-underline"
                                         href="/posts/{{$post->next->slug}}">{{$post->next->title}} &rarr;</a></div>
        @endif
    </div>
@endsection

@section('comments')
    <h2 id="comments"><a href="#comments">Comments</a></h2>

    <p>I use <a href="https://giscus.app/">Giscus</a> to delegate to <a href="https://github.com/">Github</a> for comments (you'll need a Github account, sorry). If you you'd rather, feel free to <a href="/about#contact">contact me directly</a>.</p>

    <p>The spirit of this blog is the "<a href="/about#the-title">beginner's mind</a>." As such, I would love to hear your thoughts!</p>

    <div class="my-8">
        <script src="https://giscus.app/client.js"
                data-repo="dempe/blog-comments"
                data-repo-id="R_kgDOLfkyrQ"
                data-category-id="DIC_kwDOLfkyrc4Cd7x2"
                data-mapping="pathname"
                data-strict="0"
                data-reactions-enabled="0"
                data-emit-metadata="0"
                data-input-position="top"
                data-theme="dark"
                data-lang="en"
                data-loading="lazy"
                crossorigin="anonymous"
                async>
        </script>
    </div>
@endsection
