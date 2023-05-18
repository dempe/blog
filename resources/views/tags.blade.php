@extends('layout')

@section('title')
    Tags
@endsection
@section('content')
    <table class="content-list">
        @foreach ($tags->sortBy('tag') as $tag)
            <tr>
                <td class="table-key">#{{ $tag->tag }}:&nbsp;&nbsp;</td>
                <td>
                    <a href="{{ '/tags/' . $tag->tag }}">
                        {{ collect($postTags)->filter(fn($pt) => $pt->tag == $tag->tag)->count() }} posts
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
