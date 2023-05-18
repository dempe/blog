@extends('layout')

@section('title')
    {{ $post->title }}
@endsection
@section('content')
    {!! $post->body !!}
@endsection
@section('footer-content')
    <div class="footer-content">
        <table>
            <tr>
                <td class="table-key">Published:&nbsp;&nbsp;</td>
                <td>{{ $post->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <td class="table-key">Updated:&nbsp;&nbsp;</td>
                <td>{{ $post->updated_at->format('Y-m-d H:i') }}</td>
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
    </div>
@endsection
