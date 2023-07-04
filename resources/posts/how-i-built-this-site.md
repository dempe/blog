---
title: "How I Built This Site"
slug: how-i-built-this-site
tags: tech php
---

## Why PHP

I was tired of using off-the-shelf static site generators (SSGs) like Hugo and Jekyll. I felt that I had too little control, especially when it came to their templating languages and themes. An SSG can't be *that* hard.

First of all, what do SSGs offer?

+ Markdown (or similar) to HTML conversion
+ Templating
+ A server to dynamically display local changes
+ Layouts to structure your site
+ Themes
+ Method to build raw, static site to be deployed

One day it occurred to me that PHP can accomplish most of this. PHP has been the de-facto HTML templating language since the 90s. It handles layouts easily — just nest your PHP files within other PHP files. It can handle Markdown conversion via [3rd party libraries](https://parsedown.org/) and has a built-in web server (`php -S addr:port`).

The only things PHP doesn't have are themes (I want to use my own CSS anyway) and a build command.[^1] Building's not a problem, either. I can use a simple `wget` incantation to pull down a static version of my site from the local server (see the section, "Building and Deployment").

So PHP it is.

## Site Structure

+ KISS
+ No JS
+ Index == posts
+ Drafts handled via separate branch (makes commit msgs easier, too)
+ About page
+ Tags list
+ Page for each tag dynamically generated

## Relational Database

+ Posts, slug for key
+ Tags, name for key
+ Posttags table for normalization
+ Insanely easier
+ Eloquent + eager loading
+ How I create a new post
+ Seeding, migrations

## Building and Deployment

+ Wget
+ Output dir
+ Cloudflare

## Conventions, Style, Etc.

+ Primary purpose of site is to "consume info"
+ Colors, minimize contrast
+ Off-white on off-black to reduce eye strain
+ Bold fonts
+ Text on one side to reduce eye movement on large screens
+ Responsive design
+ Writing style

## To-Do

+ 404
+ Syntax highlighting
+ IDs for each subsection for linking
+ Artisan cleanup
+ (styled) RSS feed

## Footnotes

[^1]: There are indeed PHP SSGs, but the whole reason I switched to PHP was to avoid off-the-shelf SSGs.
