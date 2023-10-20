@if(isset($post))
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
@elseif(isset($posts))
    <div class="footer-content">
        <table>
            <tr>
                <td class="table-key">Published:&nbsp;&nbsp;</td>
                <td>{{ $posts->sortBy('created_at')->first()->created_at->format('Y-m-d H:i') }}</td>
            </tr>

            <tr>
                <td class="table-key">Updated:&nbsp;&nbsp;</td>
                @if(count($posts) > 1)
                    <td>{{ $posts->sortByDesc('created_at')->first()->created_at->format('Y-m-d H:i') }}</td>
                @else
                    <td>n/a</td>
                @endif
            </tr>
        </table>
    </div>
@else
    {{--    So far, just used for about page footer--}}
    @hasSection('footer-content')
        @yield('footer-content')
    @endif
@endif

