<aside class="p-2 flex items-center justify-between">
    <p class="flex-grow text-center">@yield('text')</p>
    <figure class="w-36 m-0 h-full flex-shrink-0">
        @yield('img')
        <figcaption>
            @yield('fig-caption')
        </figcaption>
    </figure>
</aside>