---
title: "Converting Kindle Notes to Markdown"
slug: converting-kindle-notes-to-markdown
tags: tech perl regex
published: 1689846378
---

Kindle[^1] has a really cool feature that allows you to email yourself all the notes you've taken for a book. They do this by attaching an HTML file with your notes to the email.

I store all of my notes in [Obsidian](https://obsidian.md/), which uses Markdown. I thought, "Okay, I'll just use [Pandoc](https://pandoc.org/) to convert the HTML to Markdown. No problem!"

```bash 
pandoc -w markdown_strict -s -r html my_notes.html -o my_notes.md
```

## Enter: Amazon's Dumpster Fire HTML

This basically just output a bunch of plain text — no title, headings, lists, etc. That's when I realized that the notes file that Amazon sent me uses absolutely zero semantic HTML, opting instead for the ole divs-for-everything approach to web design.[^2] Then I thought, "Well, I guess it's time to bust out some Perl."

For book notes, I have one `h1` heading for the title, an `h2` heading for each chapter, and each note or idea that I have, I use a list item. Here's an example from a book I recently read, *Moonwalking with Einstein*:

```text
## ONE: THE SMARTEST MAN IS HARD TO FIND

+ *Page 13*: The reason for the monitored decline in human memory performance is because we actually do anti-Olympic training.

## TWO: THE MAN WHO REMEMBERED TOO MUCH

+ *Page 27*: "Somewhere in your mind there's a trace from everything you've ever seen."
+ *Page 42*: if there were one precept that could be said to govern his life, it is that one's highest calling is to engage in enriching escapades at every turn.
+ *Page 44*: "It is always to associate the sound of a person's name with something you can clearly imagine. It's all about creating a vivid image in your mind"
+ *Page 44*: "Baker/baker paradox."
```

And here's the HTML corresponding to the above that Amazon sent me:

```html
<div class="sectionHeading">
    ONE: THE SMARTEST MAN IS HARD TO FIND
</div><div class="noteHeading">
    Highlight(<span class="highlight_yellow">yellow</span>) - Page 13 · Location 287
</div>
<div class="noteText">
    The reason for the monitored decline in human memory performance is because we actually do anti-Olympic training.
</div><div class="sectionHeading">
    TWO: THE MAN WHO REMEMBERED TOO MUCH
</div><div class="noteHeading">
    Highlight(<span class="highlight_yellow">yellow</span>) - Page 27 · Location 472
</div>
<div class="noteText">
    Somewhere in your mind there’s a trace from everything you’ve ever seen.”
</div><div class="noteHeading">
    Highlight(<span class="highlight_yellow">yellow</span>) - Page 42 · Location 697
</div>
<div class="noteText">
    if there were one precept that could be said to govern his life, it is that one’s highest calling is to engage in enriching escapades at every turn.
</div><div class="noteHeading">
    Highlight(<span class="highlight_blue">blue</span>) - Page 44 · Location 721
</div>
<div class="noteText">
    “It is always to associate the sound of a person’s name with something you can clearly imagine. It’s all about creating a vivid image in your mind
</div><div class="noteHeading">
    Highlight(<span class="highlight_yellow">yellow</span>) - Page 44 · Location 728
</div>
<div class="noteText">
    “Baker/ baker paradox.”
</div>
```

Genius.[^3]

## Solution + Explanation

```bash 
cat my_notes.html |\
perl -pe 's|\n||g' | \
perl -pe 's|<div class="sectionHeading">(.*?)</div>|\n\n##\1\n\n|g' | \
perl -pe 's|<div class="noteHeading">|+|g' | \
perl -pe 's&Highlight\(<span class="highlight_(yellow|blue|orange)">(yellow|blue|orange)</span>\)&&g' | \
perl -pe 's| · Location \d+</div><div class="noteText">|:|g' | \
perl -pe 's|</div>||g' | \
perl -pe 's|\+\s+Note -|\n+ **Note** — |g' | \
perl -pe 's|\+\s+- Page (\d+):|\n+ Page \1:|g' | \
perl -pe 's|(Page \d+):|*\1*:|g' | \
tail -n +2 | \
pbcopy
```

`perl -pe` is basically a drop-in replacement for `sed`, but with more powerful regexes.[^4] The `-p` stands for "print". It's what makes Perl act like a stream editor (i.e., like `sed`). `-e` stands for execute and basically just tells Perl to execute the following script for each line in the file. You can also edit files in place using `-i` just like in `sed`. Maybe it's the lessons I've learned from functional programming, but I prefer not to edit files in place.

`perl -pe 's|\n||g'` removes all newlines.[^5] The `.` in Perl regexes doesn't match newlines, so this just makes all further processing easier.

`perl -pe 's|<div class="sectionHeading">(.*?)</div>|\n\n##\1\n\n|g'` — convert those ridiculous `<div>` headings to actual headings. Note that the `?` after the `*` makes `*` lazy instead of greedy. This option is not available in the POSIX regexes that `sed` uses.

`perl -pe 's|<div class="noteHeading">|+|g'` — this converts each note to a Markdown list item, `+`.

`perl -pe 's&Highlight\(<span class="highlight_(yellow|blue|orange)">(yellow|blue|orange)</span>\)&&g'` — remove the stupid HTML for highlights. I delimit with `&` to avoid conflicts with `|` (used for logical OR) and `/`.

`perl -pe 's| · Location \d+</div><div class="noteText">|:|g'` — Kindle books come with "location" information in addition to pages. I have no idea what it means, and I don't care. I just use page numbers. So I delete the location info, the following `div`, and append a `:` (page number precedes this and the actual note text will follow).

`perl -pe 's|\+\s+Note -|\n+ **Note** — |g'` — there are two types of lines in `my_notes.html` — one is just a plain quote from the book; the other is a quote with a note that I typed. Lines that start with `Note` indicate the latter. Obviously, I would like to preserve this information. This line puts `Note` s on a new line and make the `Note` word bold.

`perl -pe 's|\+\s+- Page (\d+):|\n+ Page \1:|g'` — this line basically does the same as the above, but for non- `Note` lines.

`perl -pe 's|(Page \d+):|*\1*:|g'` — Italicize page numbers.

`tail -n +2` — remember that we converted everything to a single line? The preceding regexes moved relevant content to their own lines. What's left at the top is garbage that I don't care about. This line prints the resulting file starting from the second (`+2`) line.

`pbcopy` to copy the text to my clipboard, and we're done! I can now paste the resulting Markdown into Obsidian and live happily ever after.

## Footnotes

[^1]: Overall, I'm much more of a fan of Kobo; however, I use Kindle for 3 reasons: 1 — using multiple libraries with Kobo is a nightmare, 2 — I can read my Kindle books on my phone, and 3 — what this post is about — the ability to email myself the notes I've taken is really convenient.

[^2]: Not sure if `body` counts as semantic HTML, but *they don't even use it*! (See next footnote). 😒

[^3]: They even have a `<div class="bodyContainer">`, completely redundant to `body`!

[^4]: Perl does not use POSIX regexes like `sed`. As we'll see, this is actually imperative, since there's no way to use the lazy quantifier, `?`, in POSIX. See [Comparison of regular expression engines](https://en.wikipedia.org/wiki/Comparison_of_regular_expression_engines#Language_features).

[^5]: `|` is my favorite delimiter. It's easier to see, and you have to escape it less.
