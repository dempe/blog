<? xml version = "1.0" encoding = "UTF-8" ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta name="description"
          content="A personal blog by Chris Dempewolf about science, technology, computers, and computation in general.">
    <title>Chris Dempewolf's Blog</title>
</head>
<body>
<header>
    <nav>
        <div class="site-title"><a href="/">Chris Dempewolf</a></div>
        <div class="nav-flex-container">
            <menu>
                <li><a href="/about.html">about</a></li>
                <li><a href="/resume.pdf" target="_blank">resume</a></li>
                <li><a href="/tags/index.html">tags</a></li>
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
    <div class="footer-content">
        <table>
            <tr>
                <td class="table-key">Published:&nbsp;&nbsp;</td>
                <td>{{ \Carbon\Carbon::createFromTimestamp($post->getPublished())->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <td class="table-key">Modified:&nbsp;&nbsp;</td>
                <td>{{ \Carbon\Carbon::createFromTimestamp($post->getMTime())->format('Y-m-d H:i') }}</td>
            </tr>
            @hasSection('tags')
                <tr>
                    <td class="table-key">Tags:&nbsp;&nbsp;</td>
                    <td>@yield('tags')</td>
                </tr>
            @endif
        </table>
    </div>
</footer>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js"
        data-cf-beacon="{&quot;token&quot;: &quot;1cea25a8cced4937b47752463ad53c43&quot;}"
        type="db730e4d8fbb6ce6968396cd-text/javascript"></script>
<script src="/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="db730e4d8fbb6ce6968396cd-|49" defer></script>
</body>
</html>

