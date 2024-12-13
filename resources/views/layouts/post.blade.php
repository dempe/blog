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
    <nav>
        <ul class="hidden list-none p-0 text-xl md:flex md:flex-row justify-between border-t-4 pt-8">
            <li>
                @if(isset($post->prev))
                    <a class="no-underline" href="/posts/{{$post->prev->slug}}">&larr; {{$post->prev->title}}</a>
                @endif
            </li>
            <li>
                @if(isset($post->next))
                    <a class="no-underline" href="/posts/{{$post->next->slug}}">{{$post->next->title}} &rarr;</a>
                @endif
            </li>
        </ul>
        <ul class="list-none p-0 flex flex-col items-center justify-center md:hidden">
            @if(isset($post->prev))
                <li class="mb-4 mx-auto"><a class="no-underline"
                                             href="/posts/{{$post->prev->slug}}">&larr; {{$post->prev->title}}</a></li>
            @endif
            @if(isset($post->next))
                <li class="mb-4 mx-auto"><a class="no-underline"
                                             href="/posts/{{$post->next->slug}}">{{$post->next->title}} &rarr;</a></li>
            @endif
        </ul>
    </nav>
@endsection

@section('comments')
    <h2 id="comments"><a href="#comments">Comments</a></h2>

    <p>The spirit of this blog is the "<a href="/about#the-title">beginner's mind</a>." As such, I would love to hear your thoughts!</p>

    <form class="my-8 flex flex-col" id="comment-form">
        {{--        Wrapping in div to prevent filling entire width of screen and to add line breaks. --}}
        <div>
            <label for="commenter-name"><span class="font-bold">Name</span> - <span class="italic">optional</span></label>
            <br>
            <span class="text-xs">Will be randomly generated if not provided</span>
            <br>
            <input class="mb-2 text-[#ffffff] bg-[#000000] rounded border border-solid border-[#3366FF] " type="text" id="commenter-name" name="name">
        </div>
        <div>
            <label for="commenter-website"><span class="font-bold">Website</span> - <span class="italic">optional</span></label>
            <br>
            <span class="text-xs">Can be a personal website, Twitter, Facebook, etc.</span>
            <br>
            <input class="mb-2 text-[#ffffff] bg-[#000000] rounded border border-solid border-[#3366FF] " type="url" id="commenter-website" name="website">
        </div>
        <div>
            <label class="font-bold" for="comment-input">Comment</label>
            <br>
            <textarea class="block mb-3 text-[#ffffff] bg-[#000000] rounded w-full border border-solid border-[#3366FF] p-4 " id="comment-input" placeholder="Leave a comment" rows="5" name="comment" required></textarea>
        </div>

       {{--        Wrapping in div to prevent filling entire width of screen. --}}
        <div>
            <button class="block float-right text-[#ffffff] bg-[#3366FF] rounded border border-solid border-[#ffffff] p-2 " type="submit">Submit</button>
        </div>
     </form>
@endsection
