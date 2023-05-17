@extends('layout')

@section('title')
    {{ $page->getTitle() }}
@endsection
@section('content')
    <ul class="content-list">
        @foreach ($posts as $post)
            <li>
                {{ \Carbon\Carbon::createFromTimestamp($post->createdAt)->format('Y-m-d') }}:&nbsp;&nbsp;<a
                    href="{{ '/posts/' . $post->slug }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>
@endsection
