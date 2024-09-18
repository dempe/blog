---
title: "A Tale of Two Add-Ons"
slug: a-tale-of-two-add-ons
subhead: Speculations on niche vs general solutions
tags: tech anki
published: "2024-08-21 16:59:48"
updated: "2023-09-03 11:55"
---

I made an Anki[^1] add-on to convert Markdown-formatted inline code and code blocks to HTML.

It got a bit of traction on its [Anki add-ons page](https://ankiweb.net/shared/info/1844938046) with 8 positive reviews. Not much, but I made it for myself and wasn't even expecting anyone at all to use it.

## Problems

- I later learned that my add-on was not Markdown compliant, even for the small subset of Markdown it claimed to cover (backticks within backticks).
- Additionally, Anki had since updated their editor, inserting `<br>` where there shouldn't be any (inside a `<pre>` block), which, obviously, broke my add-on.
- Users requested various features that seemed pretty reasonable to me (adding a button to the toolbar and a hotkey).

## Rewrite

Instead of fixing/implementing these, I decided to make a new add-on.  I figured that I could just use an existing Markdown library for Python to read the input and convert it to HTML. This new add-on was designed to support full Markdown syntax, along with optional extensions, rather than just focusing on code. I got it working in an hour or two and published it to the Anki add-ons page.

I am very pleased with the rewrite. In addition to delegating all the hard stuff to an off-the-shelf library, I added a lot of new parsing functionality, fixed bugs, and added the requested toolbar button. With fewer lines of code!

If my first add-on that did nothing but convert code to the proper HTML tags got 100% positive reviews, I figured that my new add-on, Simple Markdown, would receive a lot more. But that was not the case. Although the [Github repo](https://github.com/dempe/simple-markdown-for-anki) received a star, no one has left any reviews on the [add-on page](https://ankiweb.net/shared/info/354124843).

## Extrapolations

If I had never written the first add-on and went straight to the second, the lack of reviews would have conformed to my expectations. But based on my experiences with the first add-on, I found the lack of reviews strange.

What can be extrapolated from this? Could one apply any insights gained here to a more lucrative endeavor?

@include('partials.sho', ['text' => 'I think you\'re reading too much into this. They\'re just some silly add-ons for a tool that 99.999% of the world doesn\'t even know about.'])

I admit I'm hardcore speculating, but I like speculating. It's how you come up with new ideas. So to continue...

I wrote a decent add-on with a very specific purpose. I wrote a much better add-on with a much broader purpose. The former has (so far) received more traction than the latter. What drove the increased popularity of the former?

I suppose it was competition. There are already 10 other Anki add-ons claiming to provide Markdown support[^2]. There are no add-ons that specifically target Markdown code translation. I actually found it odd that people wanted to use my add-on in the first place. Why not just download a full-fledged Markdown parser?  Perhaps, like me, they desired simplicity.

I wonder if these extrapolations would work with real products. If there are 10 products on the market that accomplish X, would you be better off making a new product that specifically targets a subset of X rather than making a new product that does all of X (even if it does it better in your eyes)? More broadly, how much do the dynamics of add-ons (be it Anki, Chrome, or whatever) reflect actual market dynamics? Would be cool to try a similar experiment with apps on the Apple App Store and Google Play, however, marketing would be impossible to control for here[^3].

## Footnotes

[^1]: [Anki](https://apps.ankiweb.net/) is an [open source](https://github.com/ankitects/anki) spaced repetition system for making digital flashcards. The desktop version allows the user to install add-ons written in Python.

[^2]: Then, why make another? All the other Markdown add-ons added too much "junk", stuff I didn't need.  I made Simple Markdown, because I wanted to make the simplest Markdown add-on possible.  Something that I could install and forget that I ever had it installed.

[^3]: If it wasn't obvious, I did zero marketing for my Anki add-on, not sure about the others (I know some people do make Anki add-ons for money).  Hence, I assumed that marketing was controlled and at zero for my little experiment.