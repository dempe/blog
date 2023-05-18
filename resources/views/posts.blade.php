@extends('layout')

@section('title')
    Posts
@endsection
@section('content')
    <ul class="content-list">
        @foreach ($posts->sortByDesc('created_at') as $post)
            <li>
                {{ $post->created_at->format('Y-m-d') }}:&nbsp;&nbsp;<a href="{{ '/posts/' . $post->slug }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>
@endsection
