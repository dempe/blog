{!! "<!DOCTYPE html>" !!}

<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/assets/css/output.css"/>
    <meta name="description"
          content="A personal blog by Chris Dempewolf about science, technology, and computation."/>
    {{--    Load directly in style.css to modify properties. --}}
    {{--    <link rel="stylesheet" href="/assets/css/github-dark.min.css">--}}
    <script src="/assets/js/highlight.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <title>Chris Dempewolf's Blog</title>
</head>
<body class="bg-stone-950 text-stone-400 font-sans mx-4 my-2 max-w-fit md:mx-16 lg:mx-24 xl:mx-32">
<header class="flex flex-col mb-6">
        <a class="lg:text-7xl text-3xl font-bold no-underline" href="/">Chris Dempewolf</a>
        <nav class="flex space-x-4 mt-2 mb-8">
            <a href="/about">About</a>
            {{-- TODO: use controller to load mysite.com/resume --}}
            <a href="/resume.pdf" target="_blank">Resume</a>
            <a href="/tags/">Tags</a>
            <a href="/stats.html" target="_blank">Stats</a>
        </nav>
</header>
<main>
    <article class="my-9 pb-9">
        <h1 class="text-3xl font-bold my-2">@yield('title')</h1>
        @hasSection('metadata')
            <table class="text-sm mb-9">
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

