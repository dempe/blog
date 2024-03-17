<table class="my-9 w-full">
    @foreach ($posts->sortByDesc('created_at') as $post)
        <tr class="w-full">
            <td>{{ $post->created_at->format('Y-m-d') }}:&nbsp;&nbsp;</td>
            <td>
                <a class="text-xl font-normal" href="{{ '/posts/' . $post->slug }}">{{ $post->title }}</a>
            </td>
        </tr>
        <tr class="w-full">
            <td><!-- Empty <td> to align tags with title above. --></td>
            <td class="flex space-x-4">
                @foreach($post->tags as $tag)
                    <a class="text-xs text-stone-400 font-normal no-underline" href="{{ '/tags/' . $tag->tag }}">#{{ $tag->tag }}</a>
                @endforeach
            </td>
        </tr>
    @endforeach
</table>
