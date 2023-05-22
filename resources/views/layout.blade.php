{!! "<!DOCTYPE html>" !!}

<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="/assets/css/style.css"/>
    <meta name="description"
          content="A personal blog by Chris Dempewolf about science, technology, computers, and computation in general."/>
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
<script defer src="https://static.cloudflareinsights.com/beacon.min.js"
        data-cf-beacon="{&quot;token&quot;: &quot;1cea25a8cced4937b47752463ad53c43&quot;}"
        type="db730e4d8fbb6ce6968396cd-text/javascript"></script>
<script src="/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="db730e4d8fbb6ce6968396cd-|49" defer></script>
</body>
</html>

