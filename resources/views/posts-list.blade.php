<div class="flex flex-col my-9">
    @foreach ($posts->sortByDesc('created_at') as $post)
        <div class="flex flex-row space-x-4">
            <span class="whitespace-nowrap">
                {{ $post->created_at->format('Y-m-d') }}:&nbsp;&nbsp;
            </span>
            <div class="flex flex-col">
                <div>
                    <a class="text-lg font-normal text-neutral-200 no-underline hover:text-chartreuese" href="{{ '/posts/' . $post->slug }}">{{ $post->title }}</a>
                </div>
                <div class="flex space-x-4">
                    @foreach($post->tags as $tag)
                        <a class="text-sm text-stone-400 font-normal no-underline hover:text-chartreuse" href="{{ '/tags/' . $tag->tag }}">#{{ $tag->tag }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
