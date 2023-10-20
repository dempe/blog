@extends('layout')

@section('title')
    #{{ $tag->tag }}
@endsection
@section('content')
    <p class="tag-description">{{ $tag->description }}</p>
    @include('posts-list')
@endsection
