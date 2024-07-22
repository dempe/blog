<div class="flex flex-col my-9">
    @php
        $lastYear = null;
    @endphp
    @foreach ($posts->sortByDesc('created_at') as $post)
        @php
            $currentYear = $post->created_at->format('Y');
        @endphp
        @if ($currentYear !== $lastYear)
            <h2 id="{{ $currentYear }}"><a href="#{{ $currentYear }}">{{ $currentYear }}</a></h2>
            @php
                $lastYear = $currentYear;
            @endphp
        @endif
        <div class="flex flex-row space-x-2">
            <span class="sm:text-xs md:text-base whitespace-nowrap font-monospace">
                {{ $post->created_at->format('Y-m-d') }}:&nbsp;&nbsp;
            </span>
            <div class="flex flex-col mb-3">
                <div>
                    <a class="text-lg font-normal text-[#cccccc] no-underline" href="{{ '/posts/' . $post->slug }}">{{ $post->title }}</a>
                </div>
                <div class="flex flex-wrap">
                    @foreach($post->tags as $tag)
                        <a class="text-sm mr-3 text-[#999999] font-monospace font-normal no-underline" href="{{ '/tags/' . $tag->tag }}">#{{ $tag->tag }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
