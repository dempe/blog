@extends('layout')

@section('title')
    {{ $tag->tag }}
@endsection
@section('content')
    {{ $tag->tag }}
@endsection
{{--@section('footer-content')--}}
{{--    <div class="footer-content">--}}
{{--        <table>--}}
{{--            <tr>--}}
{{--                <td class="table-key">Published:&nbsp;&nbsp;</td>--}}
{{--                <td>{{ $post->created_at->format('Y-m-d H:i') }}</td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td class="table-key">Modified:&nbsp;&nbsp;</td>--}}
{{--                <td>{{ $post->updated_at->format('Y-m-d H:i') }}</td>--}}
{{--            </tr>--}}
{{--            @hasSection('tags')--}}
{{--                <tr>--}}
{{--                    <td class="table-key">Tags:&nbsp;&nbsp;</td>--}}
{{--                    <td>@yield('tags')</td>--}}
{{--                </tr>--}}
{{--            @endif--}}
{{--        </table>--}}
{{--    </div>--}}
{{--@endsection--}}
