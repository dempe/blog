@extends('layout')

@section('title')
    {{ $post->title }}
@endsection
@section('content')
    {!! $post->body !!}
@endsection
