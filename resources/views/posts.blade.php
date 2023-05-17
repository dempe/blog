@extends('layout')

@section('title')
    {{ $page->getTitle() }}
@endsection
@section('content')
    <ul class="content-list">
        @foreach ($posts as $post)
            <li>
                {{ \Carbon\Carbon::createFromTimestamp($post->getPublished())->format('Y-m-d') }}:&nbsp;&nbsp;<a
                    href="{{ '/posts/' . $post->getSlug() }}">{{ $post->getTitle() }}</a>
            </li>
        @endforeach
    </ul>
@endsection
