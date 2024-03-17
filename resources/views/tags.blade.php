@extends('layout')

@section('title')
    Tags
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
        <td>{{ sizeof($tags) }}</td>
    </tr>
@endsection
@section('content')
    <table>
        @foreach ($tags->sortBy('tag') as $tag)
            <tr>
                <td>#{{ $tag->tag }}:&nbsp;&nbsp;</td>
                <td>
                    <a href="{{ '/tags/' . $tag->tag }}">
                        {{ collect($postTags)->filter(fn($pt) => $pt->tag == $tag->tag)->count() }} articles
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
