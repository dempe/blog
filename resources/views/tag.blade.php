@extends('layout')

@section('title')
    #{{ $tag->tag }}
@endsection

@section('subhead')
    {!! $tag->description !!}
@endsection
@section('metadata')
    <tr>
        <td>Published:&nbsp;&nbsp;</td>
        <td>{{ $posts->sortBy('created_at')->first()->created_at->format('Y-m-d H:i') }}</td>
    </tr>
    <tr>
        <td>Updated:&nbsp;&nbsp;</td>
        <td>
            {{ $posts->sortBy('created_at')->last()->created_at->format('Y-m-d H:i') }}
        </td>
    </tr>
    <tr>
        <td>Total:&nbsp;&nbsp;</td>
        <td>{{ sizeof($posts) }}</td>
    </tr>
@endsection
@section('content')

    @include('posts-list')
@endsection
