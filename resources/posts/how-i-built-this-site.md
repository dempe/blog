---
title: "How I Built This Site"
slug: how-i-built-this-site
tags: tech php
---

I was tired of using off-the-shelf static site generators (SSGs) like Hugo and Jekyll. I felt that I had too little control, especially when it came to their templating languages and themes. An SSG can't be *that* hard.

## Why PHP

First of all, what do SSGs offer?

+ **Markdown** (or similar) to HTML conversion
+ **Templating** to inject dynamic data into a static template
+ A **server** to dynamically display local changes
+ **Layouts** to structure your site
+ **Themes**
+ A way to **build** the raw, static site to be deployed

One day it occurred to me that PHP can accomplish most of this. PHP has been the de-facto HTML templating language since the 90s. It handles layouts easily — just nest your PHP files within other PHP files. It can handle Markdown conversion via [3rd party libraries](https://parsedown.org/) and has a built-in web server (`php -S addr:port`).

The only things PHP doesn't have are themes (I want to use my own CSS anyway) and a build command.[^1] Building's not a problem, either. I can use a simple `wget` incantation to pull down a static version of my site from the local server (see the section, "Building and Deployment").

PHP it is.

## Site Structure

I want to [keep things as simple as possible](https://en.wikipedia.org/wiki/KISS_principle). The home page (`chrisdempewolf.com`) is just a list of my posts. Posts are accessed under `chrisdempewolf.com/posts/{post}`. Same for tags. Aside from that, I have an about page and my resume (see links at top).

There is no Javascript.

I had intended to have separate sections for notes (for shows, games, books, etc.) and recipes — two things I plan to blog a lot about. Then I realized that it would be simpler to just have a tag for each of these.

Most popular SSGs support some kind of draft feature. This is totally unnecessary in my opinion. I can just delegate to Git by checking out a new branch for each draft.

## Relational Database

I have two entities — posts and tags. There is a many-to-many relationship between them. On my site, each tag has its own page that is dynamically generated with a list of all the posts associated with that tag, and for each post, there is a list of tags in the footer.

This is actually pretty tricky to set up without a relational DB. With a relational DB, it's a piece of cake, and another reason I love my switch to PHP/Laravel.

In a relational DB, many-to-many relationships are modeled with 3 tables[^2] — two for the two entities and a third to store the relationships between them. For example, say `slug` is the primary key for `posts` and `tag` (the tag name) is the primary key for the table `tags`. The third table, `post_tags` has two columns — `slug` and `tag` to indicate which posts are associated with which tags and which tags are associated with which posts.

Here's what that looks like.

The `posts`, `tags`, and `post_tags` tables, respectively :

```sql
CREATE TABLE "posts" (
                "slug" VARCHAR(255) PRIMARY KEY,
                "title" VARCHAR(255),
                "body" TEXT NOT NULL,
                "created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                "updated_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP);

CREATE TABLE tags (
             "tag" VARCHAR(255) PRIMARY KEY);

CREATE TABLE "post_tags" (
				"slug" VARCHAR(255) NOT NULL,
				"tag" VARCHAR(255) NOT NULL,
				primary key ("slug", "tag"));
```

Each of these tables maps to a model in Laravel.

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
+ Internationalization

## Footnotes

[^1]: There are indeed PHP SSGs, but the whole reason I switched to PHP was to avoid off-the-shelf SSGs.

[^2]: Or they should be if your DB is properly normalized.

