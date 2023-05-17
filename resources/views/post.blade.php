@extends('layout')

@section('title')
    {{ $post->getTitle() }}
@endsection
@section('content')
        {!! $post->getBody() !!}
@endsection
@section('tags')
    {{ $post->getTags() }}
@endsection
