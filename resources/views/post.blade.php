@extends('layout')

@section('title')
    {{ $post->title }}
    <table class="post-metadata">
        <tr>
            <td class="table-key">Published:&nbsp;&nbsp;</td>
            <td>{{ $post->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        <tr>
            <td class="table-key">Updated:&nbsp;&nbsp;</td>
            <td>
                @if(isset($post->updated_at))
                    {{ $post->updated_at->format('Y-m-d H:i') }}
                @else
                    n/a
                @endif
            </td>
        </tr>
        <tr>
            <td class="table-key">Tags:&nbsp;&nbsp;</td>
            <td>
                @foreach($tags as $tag)
                    <a href="/tags/{{ $tag }}">{{ $tag }}</a>&nbsp;
                @endforeach
            </td>
        </tr>
    </table>
@endsection

@section('content')
    {!! $post->body !!}
@endsection
