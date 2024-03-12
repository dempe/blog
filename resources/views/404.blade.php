{!! "<!DOCTYPE html>" !!}

<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="https://chrisdempewolf.com/assets/css/style.css"/>
    <meta name="description"
          content="A personal blog by Chris Dempewolf about science, technology, and computation."/>
    <title>Chris Dempewolf's Blog</title>
</head>
<body>
<header>
    <nav>
        <div class="site-title"><a href="https://chrisdempewolf.com">Chris Dempewolf</a></div>
        <div class="nav-flex-container">
            <menu>
                <li><a href="https://chrisdempewolf.com/about.html">About</a></li>
                {{-- TODO: use controller to load mysite.com/resume --}}
                <li><a href="https://chrisdempewolf.com/resume.pdf" target="_blank">Resume</a></li>
                <li><a href="https://chrisdempewolf.com/tags/index.html">Tags</a></li>
            </menu>
        </div>
    </nav>
</header>
<main>
    <article>
        <h1 id="title">404</h1>
        <p id="404-message"></p>
        <script>
            const p = document.getElementById('404-message');
            const codeNode = document.createElement('code');

            codeNode.textContent = window.location.href;
            p.appendChild(document.createTextNode('The URL you entered ('));
            p.appendChild(codeNode);
            p.appendChild(document.createTextNode(') does not exist on this site.'));
        </script>
    </article>
</main>
<footer>
</footer>
</body>
</html>
