@extends('layout')

@section('title')
{{--    Posts ({{ sizeof($posts) }})--}}
    Posts
@endsection
@section('content')
    @include('posts-list')
@endsection
