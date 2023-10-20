@extends('layout')

@php
    $pd = new ParsedownExtra();
@endphp

@section('title')
    {{ $post->title }}
@endsection
@section('content')
    {!! $pd->text($post->body) !!}
@endsection
