{!! "<!DOCTYPE html>" !!}

<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A personal blog by Chris Dempewolf about science, technology, and computation."/>
    <link rel="stylesheet" href="/assets/css/output.css"/>
    <script src="/assets/js/highlight.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <link rel="icon" href="/assets/img/favicon.png" type="image/png">
    <title>Chris Dempewolf's Blog</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="antialiased box-border text-lg md:text-base bg-[#000000] text-[#cccccc] font-sans mx-auto max-w-[95%] xl:w-[1024px] mt-4 mb-8">
<header class="flex flex-col mb-6">
    <a class="text-7xl font-bold no-underline text-[#ffffff]" href="/">
        <ruby style="font-family: 'HanSerif',serif;">初心
            <rt class="text-lg font-monospace">shoshin</rt>
        </ruby>
    </a>
    <nav class="flex flex-wrap mt-2 mb-8 font-monospace">
        <a class="mr-4 no-underline" href="/about">/about</a>
        {{-- TODO: use controller to load mysite.com/resume --}}
        <a class="mr-4 no-underline" href="/resume.pdf" target="_blank">/resume</a>
        <a class="mr-4 no-underline" href="/tags/">/tags</a>
        <a class="mr-4 no-underline" href="/feed.rss" target="_blank">/rss</a>
        <a class="mr-4 no-underline" href="/stats.html" target="_blank">/stats</a>
    </nav>
</header>
<main>
    <article class="my-9 pb-9">
        <h1 class="text-3xl font-bold my-4">@yield('title')</h1>
        @hasSection('subhead')
            <p class="text-lg text-[#999999] my-4">@yield('subhead')</p>
        @endif
        @hasSection('metadata')
            <table class="mb-16 text-sm text-[#999999] font-normal no-underline font-monospace">
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
@yield('scripts')
</body>
</html>
