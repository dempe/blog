---
title: "Reducing JavaScript on My Blog"
slug: reducing-javascript-on-my-blog
subhead: 
tags: tech
published: 2024-09-11 04:27:06
---

Shower thought of the day: "Hey, is it possible to use MathJax server-side to pre-render my documents?"  I then realized this should be the case for syntax highlighting as well.  So I started researching.

I have no particular reason for wanting to remove JavaScript from my site.  Lighthouse gives my home page a 0.8 s [speed index](https://developer.chrome.com/docs/lighthouse/performance/speed-index/) and a [total blocking time](https://developer.chrome.com/docs/lighthouse/performance/lighthouse-total-blocking-time/) of 70 ms.  I doubt anyone has visited my site without Javascript or with JavaScript disabled.

In any case, I prefer having as much processing as possible take place server-side.  I feel this leads to a (slightly) faster and more consistent experience.

I don't have a lot of JS on my site to begin with.  Just a custom toggle script for my table of contents, syntax highlighting, MathJax, and Giscus for comments.

## Toggling Table of Contents

I had a simple button (`+`/`-`) that toggled the display of my table of contents:

```javascript
function toggleTOC() {
    var tocList = document.getElementById("toc-list");
    var tocButton = document.getElementById("toc-toggle");
    if (tocList.classList.contains("hidden")) {
        tocList.classList.remove("hidden");
        tocButton.innerText = "-";
    } else {
        tocList.classList.add("hidden");
        tocButton.innerText = "+";
    }
}
```

This was extremely easy to replace.  HTML has a [`<details>`](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/details) element that allows toggling the display of content without JavaScript.

My table of contents now looks like this:

```html
<aside id="toc" class="mb-8">
    <details>
        <summary class="font-bold">Table of Contents</summary>
        <ul>
            ...
```
The `<summary>` element is always displayed.  Everything else in `<details>` is displayed conditionally based on two states—`open` and `closed`.  `<details>` is `closed` (and thus hidden) by default, but you can show the contents of `<details>` by default by setting the `open` state manually: `<details open>`.

## Syntax Highlighting

This one was also very easy.  I was using [highlight.js](https://highlightjs.org/).  There is a project, [highlight.php](https://github.com/scrivo/highlight.php), that is a direct port of highlight.js for PHP.  It was just a matter of installing it and configuring my `PostController` to use it.

```php
    static function highlightHtmlCodeBlocks(string $body): string
    {
        $highlighter = new Highlighter();
        $result = self::build_dom_and_query($body, '//pre/code');
        $dom = $result->dom;
        $codeBlocks = $result->query_results;

        foreach ($codeBlocks as $codeBlock) {
            $classes = $codeBlock->getAttribute('class');
            if (preg_match('/language-(\w+)/', $classes, $matches)) {
                $language = $matches[1];
            } else {
                $language = 'plaintext';
            }

            $code = $codeBlock->textContent;

            try {
                $highlighted = $highlighter->highlight($language, $code);

                // Create a new <code> element with the language class
                $newCodeElement = $dom->createElement('code');
                $newCodeElement->setAttribute('class', 'hljs language-' . $language);

                // Append the highlighted HTML as a text node to the new <code> element
                $highlightedFragment = $dom->createDocumentFragment();
                $highlightedFragment->appendXML($highlighted->value);
                $newCodeElement->appendChild($highlightedFragment);

                // Replace the existing <code> block with the new one
                $codeBlock->parentNode->replaceChild($newCodeElement, $codeBlock);
            } catch (\Exception $e) {
                // If there's an error, leave the original code block intact
                continue;
            }
        }

        return $dom->saveHTML();
    }
```

I already had the minified highlight.js CSS included in my site's CSS, so this pretty much just worked right out of the box.

## MathJax

This one was not as simple.

### `mathjax` Node Module

The simplest solution I could find was to run a node server using the `mathjax`[^1] module that parses out and converts the dollar sign-delimited Latex in an HTML string to HTML.  I didn't like the idea of running another, parallel Node.js server.

### KaTeX

I also looked at [KaTeX](https://katex.org/), which is supposed to be a faster but less fully-featured alternative to MathJax.  Katex even has a CLI program (`npx katex`) that converts stdin (or a file) to Latex!  I was pretty excited about this until I got an error—`KaTeX parse error: Expected 'EOF', got '&'`.  "Katex can't handle HTML entities?  That's odd.  But wait.  Shouldn't it only be trying to parse text delimited by `\$`?"

Katex does not accept HTML strings.  It expects pure Latex.  That means I'd have to parse the Latex portion of my documents myself.  I'd rather not.

### Pandoc

[Pandoc](https://pandoc.org/) has a CLI, and it accepts whole HTML files/strings with embedded Latex as input! `pandoc my-post.md -o /tmp/output.html --mathml` actually works beautifully.  But not as beautifully as MathJax.  [MathML](https://developer.mozilla.org/en-US/docs/Web/MathML) is "an XML-based language for describing mathematical notation."  But it's not as widely supported, and moreover, it just doesn't *look* as good as MathJax (at least in Brave).

Pandoc also has a `--mathjax` option, but this doesn't convert anything other than the dollar sign delimiters, instead relying on client-side rendering (exactly what I was trying to get away from).

There's also a `--katex` option, but the plus signed looks weird.  I couldn't get it Pandoc with `--katex` to parse my Latex correctly anyway.

### Giving Up

There's a limit to the complexity I'm willing to add.  Running extra servers and doing a bunch of extra parsing is not something I want to maintain.

I went ahead and kept my client-side MathJax.

<mjx-container class="MathJax CtxtMenu_Attached_0" jax="CHTML" tabindex="0" ctxtmenu_counter="0" style="font-size: 121.2%; position: relative;"><mjx-math class="MJX-TEX" aria-hidden="true"><mjx-msup><mjx-mi class="mjx-i"><mjx-c class="mjx-c1D452 TEX-I"></mjx-c></mjx-mi><mjx-script style="vertical-align: 0.363em;"><mjx-texatom size="s" texclass="ORD"><mjx-mi class="mjx-i"><mjx-c class="mjx-c1D456 TEX-I"></mjx-c></mjx-mi><mjx-mi class="mjx-i"><mjx-c class="mjx-c1D70B TEX-I"></mjx-c></mjx-mi></mjx-texatom></mjx-script></mjx-msup><mjx-mo class="mjx-n" space="3"><mjx-c class="mjx-c2B"></mjx-c></mjx-mo><mjx-mn class="mjx-n" space="3"><mjx-c class="mjx-c31"></mjx-c></mjx-mn><mjx-mo class="mjx-n" space="4"><mjx-c class="mjx-c3D"></mjx-c></mjx-mo><mjx-mn class="mjx-n" space="4"><mjx-c class="mjx-c30"></mjx-c></mjx-mn></mjx-math><mjx-assistive-mml unselectable="on" display="inline"><math xmlns="http://www.w3.org/1998/Math/MathML"><msup><mi>e</mi><mrow data-mjx-texclass="ORD"><mi>i</mi><mi>π</mi></mrow></msup><mo>+</mo><mn>1</mn><mo>=</mo><mn>0</mn></math></mjx-assistive-mml></mjx-container>

## Comments

This one is the hardest.  There are a few options like [Staticman](https://staticman.net/), AWS Lambda, or email-based comments where you manually add each comment and rebuild your site (lol). All of these would require a full rebuild of the site for the comments to be displayed in addition to added complexity.

I'll just stick with Giscus.

## Conclusion

Meaningless foray? Eh, not entirely. I learned a few things.  That's what it's all about, right?

## Footnotes

[^1]: *Not* `mathjax-node`, which is another MathJax Node module that runs MathJax version 2. The bad thing about this is that `mathjax-node` does not accept a whole HTML document or string.  You have to parse out the Latex portions yourself.  No thanks.