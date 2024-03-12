@extends('layout')

@section('title')
    Tags
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
            <td>{{ sizeof($tags) }}</td>
        </tr>
    </table>
@endsection
@section('content')
    <table class="content-list tag-list">
        @foreach ($tags->sortBy('tag') as $tag)
            <tr>
                <td class="table-key">#{{ $tag->tag }}:&nbsp;&nbsp;</td>
                <td>
                    <a href="{{ '/tags/' . $tag->tag }}">
                        {{ collect($postTags)->filter(fn($pt) => $pt->tag == $tag->tag)->count() }} articles
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
