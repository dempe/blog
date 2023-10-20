<table class="content-list">
    @foreach ($posts->sortByDesc('created_at') as $post)
        <tr>
            <td>{{ $post->created_at->format('Y-m-d') }}:&nbsp;&nbsp;</td>
            <td>
                <a href="{{ '/posts/' . $post->slug }}">{{ $post->title }}</a>
            </td>
        </tr>
        <tr class="row-with-margin">
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
