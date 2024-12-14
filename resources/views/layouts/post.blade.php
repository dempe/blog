@extends('layouts.layout')

@section('title')
    {{ $post->title }}
@endsection

@section('subhead')
    {!! $post->subhead  !!}
@endsection

@section('metadata')
    <tr>
        <td>Published:&nbsp;&nbsp;</td>
        <td>{{ $post->created_at->format('Y-m-d') }}</td>
    </tr>
    @if(isset($post->updated_at))
        <tr>
            <td>Updated:&nbsp;&nbsp;</td>
            <td>
                {{ $post->updated_at->format('Y-m-d') }}
            </td>
        </tr>
    @endif
    <tr>
        <td>Words:</td>
        <td>{{ $post->wc }}</td>
    </tr>
    <tr>
        <td>Tags:&nbsp;&nbsp;</td>
        <td>
            @foreach($tags as $tag)
                <a class="no-underline" href="/tags/{{ $tag }}">#{{ $tag }}</a>&nbsp;
            @endforeach
        </td>
    </tr>
@endsection

@section('toc')
    @if(isset($post->toc))
        {!! $post->toc !!}
    @endif
@endsection

@section('content')
    {!! $post->body !!}
@endsection

@section('prev-next')
    <nav>
        <ul class="hidden list-none p-0 text-xl md:flex md:flex-row justify-between border-t-4 pt-8">
            <li>
                @if(isset($post->prev))
                    <a class="no-underline" href="/posts/{{$post->prev->slug}}">&larr; {{$post->prev->title}}</a>
                @endif
            </li>
            <li>
                @if(isset($post->next))
                    <a class="no-underline" href="/posts/{{$post->next->slug}}">{{$post->next->title}} &rarr;</a>
                @endif
            </li>
        </ul>
        <ul class="list-none p-0 flex flex-col items-center justify-center md:hidden">
            @if(isset($post->prev))
                <li class="mb-4 mx-auto"><a class="no-underline"
                                             href="/posts/{{$post->prev->slug}}">&larr; {{$post->prev->title}}</a></li>
            @endif
            @if(isset($post->next))
                <li class="mb-4 mx-auto"><a class="no-underline"
                                             href="/posts/{{$post->next->slug}}">{{$post->next->title}} &rarr;</a></li>
            @endif
        </ul>
    </nav>
@endsection

@section('comments')
    <h2 id="comments"><a href="#comments">Comments</a></h2>

    <p>The spirit of this blog is the "<a href="/about#the-title">beginner's mind</a>." As such, I would love to hear your thoughts!</p>

    <form class="my-8 flex flex-col" id="comment-form">
        {{--        Wrapping in div to prevent filling entire width of screen and to add line breaks. --}}
        <div>
            <label for="commenter-name"><span class="font-bold">Name</span> - <span class="italic">optional</span></label>
            <br>
            <small id="commenter-name-description" class="text-xs">Will be set to "Anonymous" if not provided</small>
            <br>
            <input class="mb-2 text-[#ffffff] bg-[#000000] rounded border border-solid border-[#3366FF]"
                   type="text"
                   id="commenter-name"
                   name="name"
                   placeholder="Anonymous"
                   aria-describedby="commenter-name-description">
        </div>
        <div>
            <label for="commenter-website"><span class="font-bold">Website</span> - <span class="italic">optional</span></label>
            <br>
            <small id="commenter-website-description" class="text-xs">Can be a personal website, Twitter, Facebook, etc.</small>
            <br>
            <input class="mb-2 text-[#ffffff] bg-[#000000] rounded border border-solid border-[#3366FF]"
                   type="url"
                   id="commenter-website"
                   name="website"
                   aria-describedby="commenter-website-description">
        </div>
        <div>
            <label class="font-bold" for="comment-input">Comment</label>
            <br>
            <small id="comment-description" class="text-xs">Markdown supported—use ">" to reply</small>
            <textarea class="block mb-3 text-[#ffffff] bg-[#000000] rounded w-full border border-solid border-[#3366FF] p-4"
                      id="comment-input"
                      placeholder="Leave a comment"
                      rows="5"
                      name="comment"
                      aria-describedby="comment-input-error"
                      required></textarea>
        </div>

       {{-- Wrapping in div to prevent filling entire width of screen. --}}
        <div class="flex justify-end">
            <button class="block text-[#ffffff] bg-[#3366FF] hover:bg-[#0033FF] rounded border border-solid border-[#ffffff] p-2 " type="submit">Submit</button>
        </div>
     </form>

    <h3 id="replies"></h3>
    <div class="flex flex-col" id="comments-container"></div>


    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.1242.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/showdown/dist/showdown.min.js"></script>
    <script>
        const API_ENDPOINT = 'https://upjo1dal62.execute-api.us-east-1.amazonaws.com/comments';

        async function fetchComments() {
            try {
                const response = await fetch(`${API_ENDPOINT}/{{ $post->slug }}`);
                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.statusText}`);
                }

                const data = await response.json();
                console.log('Fetched comments:', data);

                // Assuming `data` is an array of comment items
                return Array.isArray(data) ? data : [];
            } catch (err) {
                console.error('Error retrieving comments:', err);
                return [];
            }
        }

        (async () => {
            const comments = await fetchComments();
            const commentsCount = document.getElementById('replies');
            commentsCount.innerHTML = `<a href="#replies">${comments.length} replies to "{{ $post->title }}"</a>`
            console.log(comments);

            displayComments(comments);
        })();

        function displayComments(comments) {
            const container = document.getElementById('comments-container');

            // Clear existing comments (if any)
            container.innerHTML = '';

            for (let i = 0; i < comments.length; i++) {
                const comment = comments[i];
                const commenter = comment.commenter.S ? comment.commenter.S : 'Anonymous';
                const commentDiv = document.createElement('div');
                commentDiv.className = 'comment';
                commentDiv.id = comment.id.S;

                const nameElement = document.createElement('p');
                nameElement.innerHTML = comment.website
                    ? `<strong><a class="no-underline" href="${comment.website.S}" target="_blank" rel="noopener noreferrer">${commenter}</a></strong>`
                    : `<strong>${commenter}</strong>`;
                commentDiv.appendChild(nameElement);

                const dateTimeElement = document.createElement('small');
                dateTimeElement.innerHTML = `<a class="no-underline font-monospace" href="#${comment.id.S}">${formatDateTime(comment.datetime.S)}</a>`;
                commentDiv.appendChild(dateTimeElement);

                const commentText = document.createElement('p');
                commentText.className = 'comment-text'
                const converter = new showdown.Converter();
                commentText.innerHTML = converter.makeHtml(comment.comment.S);
                commentDiv.appendChild(commentText);

                container.appendChild(commentDiv);
            }

            function formatDateTime(isoString) {
                const date = new Date(isoString);
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                const day = String(date.getDate()).padStart(2, '0');
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const seconds = String(date.getSeconds()).padStart(2, '0');

                return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            }
        }
    </script>
@endsection
