@extends('layout')

@section('title')
    Posts
@endsection
@section('content')
    <table class="content-list">
        @foreach ($posts->sortByDesc('created_at') as $post)
            <tr>
                <td>{{ $post->created_at->format('Y-m-d') }}:&nbsp;&nbsp;</td>
                <td>
                    <a href="{{ '/posts/' . $post->slug }}">{{ $post->title }}</a>
                </td>
            </tr>
            <tr class="tag-row">
                <td><!-- Empty <td> to align tags with title above. --></td>
                <td>
                    <ul class="post-tag-list">
                        @foreach($post->tags as $tag)
                            <li><a href="{{ '/tags/' . $tag->tag }}">#{{ $tag->tag }}</a></li>
                        @endforeach
                    </ul>
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
