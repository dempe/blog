<div class="flex flex-col my-9">
    @foreach ($posts->sortByDesc('created_at') as $post)
        <div class="flex flex-row space-x-4">
            <span class="whitespace-nowrap font-monospace">
                {{ $post->created_at->format('Y-m-d') }}:&nbsp;&nbsp;
            </span>
            <div class="flex flex-col mb-3">
                <div>
                    <a class="text-lg font-normal text-[#cccccc] no-underline" href="{{ '/posts/' . $post->slug }}">{{ $post->title }}</a>
                </div>
                <div class="flex space-x-4">
                    @foreach($post->tags as $tag)
                        <a class="text-sm text-[#999999] font-monospace font-normal no-underline" href="{{ '/tags/' . $tag->tag }}">#{{ $tag->tag }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
