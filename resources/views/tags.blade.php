@extends('layout')

@section('title')
    Tags
@endsection
@section('content')
    <ul class="content-list">
        @foreach ($tags->sortBy('tag') as $tag)
            <li>
                <a href="{{ '/tags/' . $tag->tag }}">#{{ $tag->tag }}</a>
            </li>
        @endforeach
    </ul>
@endsection
