@extends('layout')

@section('title')
    Tags
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
@section('footer-content')
    <div class="footer-content">
        <table>
            <tr>
                <td class="table-key">Published:&nbsp;&nbsp;</td>
                <td>{{ $posts->sortBy('created_at')->first()->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @if(count($posts) > 1)
                <tr>
                    <td class="table-key">Updated:&nbsp;&nbsp;</td>
                    <td>{{ $posts->sortByDesc('created_at')->first()->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endif
        </table>
    </div>
@endsection
