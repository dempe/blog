{!! "<!DOCTYPE html>" !!}

<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="/assets/css/style.css"/>
    <meta name="description"
          content="A personal blog by Chris Dempewolf about science, technology, and computation."/>
    <link rel="stylesheet" href="/assets/css/github-dark.min.css">
    <script src="/assets/js/highlight.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <title>Chris Dempewolf's Blog</title>
</head>
<body>
<header>
    <nav>
        <div class="site-title"><a href="/">Chris Dempewolf</a></div>
        <div class="nav-flex-container">
            <menu>
                <li><a href="/about">About</a></li>
                {{-- TODO: use controller to load mysite.com/resume --}}
                <li><a href="/resume.pdf" target="_blank">Resume</a></li>
                <li><a href="/tags/">Tags</a></li>
            </menu>
        </div>
    </nav>
</header>
<main>
    <article>
        <h1 id="title">@yield('title')</h1>
        @yield('post-metadata')
        @yield('toc')
        @yield('content')
    </article>
</main>
<footer>
    @yield('nav')
</footer>
@yield('scripts')
</body>
</html>

