{!! "<!DOCTYPE html>" !!}

<html lang="en">
<head>
    <title>{{ trim(strip_tags($__env->yieldContent('title', 'Shoshin'))) }}</title>

    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description"
          content="{{ trim(strip_tags($__env->yieldContent('subhead', 'A personal blog by Chris Dempewolf about science, technology, computation, recipes, etc.'))) }}"/>
    <meta name="license" content="https://creativecommons.org/licenses/by-sa/4.0/" />


    <meta property="og:site_name" content="shoshin"/>
    <meta property="og:title" content="{{ trim(strip_tags($__env->yieldContent('title', 'Shoshin'))) }}"/>
    <meta property="og:description"
          content="{{ trim(strip_tags($__env->yieldContent('subhead', 'A personal blog by Chris Dempewolf about science, technology, computation, recipes, etc.'))) }}"/>

    <meta name="twitter:card" content="summary"/>
    {{--    <meta name="twitter:site" content="@username" />--}}
    <meta name="twitter:title" content="{{ trim(strip_tags($__env->yieldContent('title', 'Shoshin'))) }}"/>
    <meta name="twitter:description"
          content="{{ trim(strip_tags($__env->yieldContent('subhead', 'A personal blog by Chris Dempewolf about science, technology, computation, recipes, etc.'))) }}"/>
    <meta name="twitter:image" content="/assets/img/favicon.png"/>

{{--    Use the ICO image as a default--}}
    <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../assets/css/output.css"/>
</head>
<body class="grad-bg  min-h-screen antialiased box-border text-lg md:text-base bg-[#000000] text-[#cccccc] font-sans mx-auto max-w-[95%] xl:w-[1024px] mt-4 mb-8">
<header class="flex flex-col mb-6">
    <a class="text-7xl font-bold no-underline text-[#ffffff]" href="/">
        <ruby style="font-family: 'HanSerif',serif;">初心
            <rt class="text-lg font-monospace">shoshin</rt>
        </ruby>
    </a>
    <hr class="border-[#ffffff] w-full border-1 transform scale-y-50"/>
    <nav class="mt-2 mb-8 font-monospace" aria-label="Main navigation">
        <ul class="p-0 list-none text-xl flex flex-row flex-wrap">
            <li><a class="mr-4 no-underline" href="/about">/about</a></li>
            <li><a class="mr-4 no-underline" href="/tags/">/tags</a></li>
            {{-- TODO: use controller to load mysite.com/resume --}}
            <li><a class="mr-4 no-underline" href="/resume.pdf" target="_blank">/resume</a></li>
            <li><a class="mr-4 no-underline" href="/feed.rss" target="_blank">/rss</a></li>
            <li><a class="mr-4 no-underline" href="https://chrisdempewolf.com/stats.html" target="_blank">/stats</a></li>
        </ul>
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
    @yield('prev-next')
    @yield('comments')
    <hr id="bottom" class="border-[#ffffff] my-2 w-full border-1 transform scale-y-50"/>
    <nav>
        <ul class="m-0 p-0 list-none text-xl flex flex-row justify-between">
            <li><a class="m-0 no-underline" href="/">/home</a></li>
            <li><a class="m-0 no-underline"  href="#">/top</a></li>
        </ul>
    </nav>
    <p class="text-center">&copy; 2023 - {{ date("Y") }} Christopher Dempewolf</p>
    <p class="text-center">Unless otherwise noted, all content on this site is hereby licensed under the <a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" rel="license">
            Creative Commons Attribution-ShareAlike 4.0 International License
        </a>. This excludes my resume for which I retain full rights.</p>
</footer>
</body>
</html>
