@extends('layout')

@section('title')
    Posts
@endsection

@section('post-metadata')
    <table class="post-metadata">
        <tr>
            <td class="table-key">Published:&nbsp;&nbsp;</td>
            <td>{{ $posts->sortBy('created_at')->first()->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        <tr>
            <td class="table-key">Updated:&nbsp;&nbsp;</td>
            <td>
                {{ $posts->sortBy('created_at')->last()->created_at->format('Y-m-d H:i') }}
            </td>
        </tr>
        <tr>
            <td class="table-key">Total:&nbsp;&nbsp;</td>
            <td>{{ sizeof($posts) }}</td>
        </tr>
    </table>
@endsection

@section('content')
    @include('posts-list')
@endsection
