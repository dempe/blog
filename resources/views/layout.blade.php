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
</head>
<body class="bg-stone-950 text-stone-350 font-sans my-2 mx-auto sm:w-[90%] md:w-[80%] lg:w-[700px] xl:w-[1024px] px-4 sm:px-6 md:px-8 lg:px-10 xl:px-12">
<header class="flex flex-col mb-6">
    <a class="text-3xl font-bold no-underline text-stone-200 hover:text-chartreuse text-7xl" href="/"><span style="font-family: 'HanSerif';">初心 </span><br>Shoshin</a>
    <nav class="flex space-x-4 mt-2 mb-8">
        <a class="" href="/about">About</a>
        {{-- TODO: use controller to load mysite.com/resume --}}
        <a href="/resume.pdf" target="_blank">Resume</a>
        <a href="/tags/">Tags</a>
        <a href="/feed.rss" target="_blank">RSS</a>
        <a href="/stats.html" target="_blank">Stats</a>
    </nav>
</header>
<main>
    <article class="my-9 pb-9">
        <h1 class="text-3xl font-bold my-2">@yield('title')</h1>
        @hasSection('metadata')
            <table class="mb-16 text-sm text-stone-400 font-normal no-underline">
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
