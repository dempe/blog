{!! "<!DOCTYPE html>" !!}

<html lang="en">
<head>
    <title>{{ trim(strip_tags($__env->yieldContent('title', 'shosin'))) }}</title>

    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description"
          content="{{ trim(strip_tags($__env->yieldContent('subhead', 'A personal blog by Chris Dempewolf about science, technology, and computation.'))) }}"/>

    <meta property="og:site_name" content="shoshin"/>
    <meta property="og:title" content="{{ trim(strip_tags($__env->yieldContent('title', 'Shosin'))) }}"/>
    <meta property="og:description"
          content="{{ trim(strip_tags($__env->yieldContent('subhead', 'A personal blog by Chris Dempewolf about science, technology, and computation.'))) }}"/>

    <meta name="twitter:card" content="summary"/>
    {{--    <meta name="twitter:site" content="@username" />--}}
    <meta name="twitter:title" content="{{ trim(strip_tags($__env->yieldContent('title', 'Shosin'))) }}"/>
    <meta name="twitter:description"
          content="{{ trim(strip_tags($__env->yieldContent('subhead', 'A personal blog by Chris Dempewolf about science, technology, and computation.'))) }}"/>
    <meta name="twitter:image" content="/assets/img/favicon.png"/>

{{--    Use the ICO image as a default--}}
    <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/output.css"/>
</head>
<body class="antialiased box-border text-lg md:text-base bg-[#000000] text-[#cccccc] font-sans mx-auto max-w-[95%] xl:w-[1024px] mt-4 mb-8">
<header class="flex flex-col mb-6">
    <a class="text-7xl font-bold no-underline text-[#ffffff]" href="/">
        <ruby style="font-family: 'HanSerif',serif;">初心
            <rt class="text-lg font-monospace">shoshin</rt>
        </ruby>
    </a>
    <hr class="border-[#ffffff] my-2 w-full border-1 transform scale-y-50"/>
    <nav class="flex flex-wrap mt-2 mb-8 font-monospace">
        <a class="mr-4 no-underline" href="/about">/about</a>
        <a class="mr-4 no-underline" href="/tags/">/tags</a>
        {{-- TODO: use controller to load mysite.com/resume --}}
        <a class="mr-4 no-underline" href="/resume.pdf" target="_blank">/resume</a>
{{--        <a class="mr-4 no-underline" href="/feed.rss" target="_blank">/rss</a>--}}
        <a class="mr-4 no-underline" href="https://chrisdempewolf.com/stats.html" target="_blank">/stats</a>
    </nav>
</header>
<main>
    <article class="my-9 pb-9">
        <h1 class="text-3xl font-bold my-4">@yield('title')</h1>
        @hasSection('subhead')
            <p class="text-lg text-[#999999] my-4">@yield('subhead')</p>
        @endif
        @hasSection('metadata')
            <table class="metadata mb-8 text-sm text-[#999999] font-normal no-underline font-monospace">
                @yield('metadata')
            </table>
        @endif
        @yield('toc')
        @yield('content')
    </article>
</main>
<footer>
    @yield('nav')
    @yield('comments')
</footer>
<hr id="bottom" class="border-[#ffffff] my-2 w-full border-1 transform scale-y-50"/>
<p class="text-center">Return to <a href="#">top</a></p>
</body>
</html>
