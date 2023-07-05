{!! "<!DOCTYPE html>" !!}

<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="/assets/css/style.css"/>
    <meta name="description"
          content="A personal blog by Chris Dempewolf about science, technology, computers, and computation in general."/>
    <link rel="stylesheet" href="/assets/css/syntax-styles/github-dark.min.css">
    <script src="/assets/js/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
    <title>Chris Dempewolf's Blog</title>
</head>
<body>
<header>
    <nav>
        <div class="site-title"><a href="/">Chris Dempewolf</a></div>
        <div class="nav-flex-container">
            <menu>
                <li><a href="/about">about</a></li>
                {{-- TODO: use controller to load mysite.com/resume --}}
                <li><a href="/resume.pdf" target="_blank">resume</a></li>
                <li><a href="/tags/">tags</a></li>
            </menu>
        </div>
    </nav>
</header>
<main>
    <article>
        <h1>@yield('title')</h1>
        @yield('content')
    </article>
</main>
<footer>
    @hasSection('footer-content')
        @yield('footer-content')
    @endif
</footer>
</body>
</html>

