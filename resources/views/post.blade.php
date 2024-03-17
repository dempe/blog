@extends('layout')

@section('title')
    {{ $post->title }}
@endsection

@section('metadata')
    <tr>
        <td>Published:&nbsp;&nbsp;</td>
        <td>{{ $post->created_at->format('Y-m-d H:i') }}</td>
    </tr>
    @if(isset($post->updated_at))
        <tr>
            <td>Updated:&nbsp;&nbsp;</td>
            <td>
                {{ $post->updated_at->format('Y-m-d H:i') }}
            </td>
        </tr>
    @endif
    <tr>
        <td>Tags:&nbsp;&nbsp;</td>
        <td>
            @foreach($tags as $tag)
                <a href="/tags/{{ $tag }}">{{ $tag }}</a>&nbsp;
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

@section('comments')
    <h2 id="comments">Comments</h2>
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
@endsection

@section('nav')
    <nav class="hidden md:flex md:flex-row justify-between border-t-4 pt-8">
        <div>
            @if(isset($post->prev))
                <span>⬅️ <a href="http://localhost:8000/posts/{{$post->prev->slug}}">{{$post->prev->title}}</a></span>
            @endif
        </div>
        <div>
            @if(isset($post->next))
                <span><a href="http://localhost:8000/posts/{{$post->next->slug}}">{{$post->next->title}}</a> ➡️</span>
            @endif
        </div>
    </nav>

    <ul class="md:hidden">
        @if(isset($post->prev))
            <li class="mb-2">Previous post: <a href="http://localhost:8000/posts/{{$post->prev->slug}}">{{$post->prev->title}}</a></li>
        @endif
        @if(isset($post->next))
            <li>Next post: <a href="http://localhost:8000/posts/{{$post->next->slug}}">{{$post->next->title}}</a></li>
        @endif
    </ul>
@endsection

@section('scripts')
    <script>
        MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']]
            },
            svg: {
                fontCache: 'global'
            }
        };
    </script>
    <script>hljs.highlightAll();</script>

    {{--    <script>--}}
    {{--        document.getElementById('toc-toggle').addEventListener('click', function() {--}}
    {{--            var toc = document.getElementById('toc').getElementsByTagName('ul')[0];--}}
    {{--            var span = this.getElementsByTagName('span')[0]; // Get the <span> inside the button--}}

    {{--            // Toggle the display of the TOC--}}
    {{--            if (toc.style.display === 'none') {--}}
    {{--                toc.style.display = 'block';--}}
    {{--                span.textContent = '-'; // Change to "-" when TOC is shown--}}
    {{--            } else {--}}
    {{--                toc.style.display = 'none';--}}
    {{--                span.textContent = '+'; // Change back to "+" when TOC is hidden--}}
    {{--            }--}}
    {{--        });--}}
    {{--    </script>--}}
@endsection
