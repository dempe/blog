@extends('layout')

@section('title')
    #{{ $tag->tag }}
@endsection
@section('content')
    <ul class="content-list">
        @foreach ($posts->sortByDesc('created_at') as $post)
            <li>
                {{ $post->created_at->format('Y-m-d') }}:&nbsp;&nbsp;<a
                    href="{{ '/posts/' . $post->slug }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>
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
