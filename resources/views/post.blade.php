@extends('layout')

@section('title')
    {{ $post->title }}
@endsection

@section('post-metadata')
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

@section('toc')
    @if(isset($post->toc))
        {!! $post->toc !!}
    @endif
@endsection

@section('content')
    {!! $post->body !!}
@endsection

@section('scripts')
{{--    <script>--}}
{{--        document.getElementById('toc-toggle').addEventListener('click', function() {--}}
{{--            var toc = document.getElementById('toc').getElementsByTagName('ul')[0];--}}
{{--            var span = this.getElementsByTagName('span')[0]; // Get the <span> inside the button--}}

{{--            // Toggle the display of the TOC--}}
{{--            if (toc.style.display === 'none') {--}}
{{--                toc.style.display = 'block';--}}
{{--                span.textContent = '-'; // Change to "-" when TOC is shown--}}
{{--            } else {--}}
{{--                toc.style.display = 'none';--}}
{{--                span.textContent = '+'; // Change back to "+" when TOC is hidden--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
@endsection
