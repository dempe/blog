---
title: Building a Static Site from Scratch
slug: building-a-static-site-from-scratch
subhead: The technologies used, problems faced, and lessons learned in building my own static site generator
tags: tech php
published: "2023-07-05 23:53:06"
updated: "2024-07-16 10:03:44"
---

## First of All, Why?

**One**, I wanted the [Ikea effect](https://en.wikipedia.org/wiki/IKEA_effect) of building my own blog from scratch.

**Two**, I feel that off-the-shelf static site generators (SSGs) like Hugo and Jekyll don't provide me with the control I want, especially when it comes to templating languages and themes.

**Three**, I did it for the learning experience. I'd rather spend my time learning technologies more reusable than a pre-built SSG framework. In building this site, I've learned and/or reinforced my knowledge in several topics: utility-first CSS ([Tailwind](https://tailwindcss.com/)), database normalization, MVC, the N+1 problem and eager loading, PHP, and many more specific technologies. More importantly, it was good practice designing a system from scratch.

## Where To Start?

First, what do SSGs offer?

+ **Markdown** (or similar) to HTML conversion
+ **Templating** to inject data into a standard template
+ A **server** to dynamically display local changes
+ **Layouts** to structure your site
+ **Themes**
+ A way to **build** the raw, static site to be deployed
+ **Drafts** are unnecessary in my opinion. I delegate to Git by checking out a new branch for each draft (`draft/my-post-title`).

The biggest problems I have with SSGs are with templates, layouts, and themes.  Handling themes on my own is no problem. I can easily style the site the way I want with Tailwind. Then what about templates and layouts?  What about the other problems?

PHP has been the *de facto* HTML templating language since the 90s [^1], and layouts are also a cinch — just nest your PHP files within other PHP files. PHP can handle Markdown conversion via 3rd party libraries, and it has a built-in web server via `php -S addr:port` (`php artisan serve` if you're using Laravel) [^2].

That leaves building.  For that, I use `wget` to save a static version of my site from the local server. Then I just need to push that to my S3 bucket. I have added all of my build and deploy scripts to Github Actions, so that my site builds and deploys upon pushing to `github/main`.

PHP/[Laravel](https://laravel.com/) it is.

## Site Structure

I want to [keep things as simple as possible](https://en.wikipedia.org/wiki/KISS_principle). The home page (`chrisdempewolf.com`) is just a list of my posts. Individual posts are accessed under `chrisdempewolf.com/posts/{post}`. Analogously for tags. Aside from that, I have an about page and my resume (see links at top). EDIT: I have since added a [stats](/stats) page built every Wednesday at midnight using [GoAccess](https://goaccess.io/) and Github Actions and an [RSS feed](/feed.rss).

I had intended to have separate sections for notes (notes about shows, games, books, etc.) and recipes — two things I plan to blog a lot about. Then I realized that it would be simpler to just have a tag for each of these categories.

## Keeping Track of Posts and Tags with a Database

When running my local Laravel server, I use [SQLite](https://www.sqlite.org/) to store two entities — `posts` and `tags`.

There is a many-to-many relationship between these two entities. Each tag has its own page that is dynamically generated with a list of all the posts associated with that tag, and for each post, there is a list of tags in the footer.

This can be somewhat tricky to set up without a relational DB. With a relational DB, it's a piece of cake.

In a relational DB, many-to-many relationships are modeled with 3 tables[^3] — two for the two entities and a third to store the relationships between them. For example, say `slug` is the primary key for `posts` and `tag` (the tag name) is the primary key for the table `tags`. The third table, `post_tags` has two columns — `slug` and `tag` to indicate which posts are associated with which tags and which tags are associated with which posts.

Here's what that looks like.

The `posts`, `tags`, and `post_tags` tables, respectively :

```sql
CREATE TABLE "posts" (
                "slug" VARCHAR(255) PRIMARY KEY,
                "title" VARCHAR(255),
                "subhead" VARCHAR(255),
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

Each of these tables maps to a model in Laravel. I can then use Laravel's ORM, [Eloquent](https://laravel.com/docs/10.x/eloquent).

The root directory of my site is just a method on my `PostController`:

```php
public function index() {
    return view('posts', ['posts' => Post::all()]);
}
```

A simple `SELECT *`.

How can I get all posts for a tag? Here's the relevant portion from the `PostController`:

```php
return view('post', ['post' => $post,
                     'tags' => PostTag::where('slug', $slug)->pluck('tag')]);
```

One line!

To be fair, there was a bit of work I had to do on the models to make them aware of the relationships between `posts`, `tags`, and `post_tags`. Enter [Eloquent relationships](https://laravel.com/docs/10.x/eloquent-relationships).

<aside>My main reason for storing posts and tags in a database was to make it easy to track the relationships between them. You'll notice the body of the post has nothing to do with this. I considered not adding the body to the database, but I added it anyway for two reasons. One, it allows me to track update times for posts easily. Two, it's nice to have a single source for all of my data, as opposed to loading the post bodies from files and everything else from the database.</aside>

## Eloquent Relationships

Eloquent allows you to define relationships on your models via methods. It does this by providing various types associated with each type of relationship (one-to-one, one-to-many, many-to-many, etc.). To define a relationship, you need to implement a method on your model that returns the appropriate relationship type.

In my case, I implemented a method that returns `BelongsToMany` on both the `Post` model and the `Tag` model. Here's what that method looks like on the `Tag` model:

```php
public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            Post::class,
            PostTag::class,
            'tag',
            'slug',
            'tag',
            'slug'
        );
    }
```

There's a lot of parameters here, but it's not too bad. The first parameter to `belongsToMany` tells Eloquent that a `Tag` can have many `Post` s. The second parameter (`PostTag::class`) tells Eloquent that `Tag` s are related to `Post` s via `PostTag` (the `post_tags` table) AKA a "pivot table"[^4].

The remaining fields are IDs. You don't always have to explicitly pass IDs to Eloquent relation methods. I do, because I have custom ID fields for all my tables. The third parameter tells Eloquent that `tag` is the foreign key on the `post_tags` table. The fourth argument tells Eloquent that `slug` is the foreign key on the `posts_tags` table for `posts`. The fifth argument tells Eloquent that `tag` is the key for the `tags` table. Finally, the sixth argument tells Eloquent that `slug` is the key for the `posts` table.

All this allows me to use that nice chain syntax from above. Again, because it's so beautiful: `$posts = $tag->posts()->get();`.

But that's not all. It also allows for something called "**eager loading**".

## Avoiding N+1 with Eager Loading

Eager loading is Eloquent's way of averting the [N+1 query problem](https://stackoverflow.com/questions/97197/what-is-the-n1-selects-problem-in-orm-object-relational-mapping). Here's how you use it.

Say I have the following code:

```php
$posts = Post::all();

foreach ($posts as $post) {
    foreach ($post->tags as $tag) {
        echo $tag->name;
    }
}
```

This results in N+1 queries — 1 to fetch all posts and N to fetch the tags for each post. If you query the DB directly, you would just do a `join`, but Eloquent has no idea that we are going to fetch the tags for each post when we call `Post::all();`. This is, in fact, a common problem with all ORMs.

Now that we've defined our relationships on each model, we can *tell* Eloquent that we are going to fetch each post's tags (i.e, use eager loading).

```php
$posts = Post::with('tags')->get();

foreach ($posts as $post) {
    foreach ($post->tags as $tag) {
        echo $tag->name;
    }
}
```

The key thing to note here is `::with('tags')`. This makes Eloquent eagerly load the tags along with the posts. Instead of running N+1 queries, we're now only running 1 query[^5]!

Eloquent does this by attaching an array of `Tag` s to each `Post` when you call `Post::with('tags')->get()`. You can see this by running `php artisan tinker` and comparing the two outputs — lazy and eager.

## Seeding and Migrations

### Seeding

As mentioned, I store all of my posts in a database. This allows me to easily handle the many-to-many relationship between posts and tags. But I need to actually import the posts.

I realize it's a huge anti-pattern, but so far I've been using DB seeders for this purpose. It allows me to programmatically load my posts without leaving `artisan` while taking advantage of Laravel's built-in seeding functionality.

However, I would like to migrate away from this, since this is not the intended purpose of seeders.  Instead, I plan to create a custom `artisan` command to update my `posts` table to reflect my `resources/posts` directory. This will remove the anti-pattern while allowing me to continue using `artisan`.

### Migrations 

I have pretty standard migrations for each table, `posts`, `tags`, and `post_tags`. The only hiccup was that I needed to use raw SQL (via the `DB::statement` method) on the `posts` table. Sqlite doesn't have `ON UPDATE CURRENT_TIMESTAMP` like in MySQL. Instead, I had to create a trigger:

```php
DB::statement('CREATE TRIGGER update_post_updated_at UPDATE ON posts
                BEGIN
                    UPDATE posts SET updated_at = CURRENT_TIMESTAMP WHERE OLD.slug = NEW.slug;
                END;');
```

Doing this allows me to track when posts were last updated, which I display in the post's footer.

## Creating a New Post

I made a custom Artisan command to make a new post: `php artisan make:post <title> <tags>`. For this post, I ran `php artisan make:post "Building a Static Site from Scratch" "tech php"`. This slugifys the title and creates a new file, `resources/posts/building-a-static-site-from-scratch.md`.

After the new post has been imported to the DB, I can go to the URL `<host>/posts/building-a-static-site-from-scratch`.

It loads the `post` view, which is a Blade template:

```php-template
@extends('layout')

@section('title')
    {{ $post->title }}
@endsection
@section('content')
    {!! $post->body !!}
@endsection
```

## Building and Deployment

I want a static site. Hosting them is cheap (free), and as fast and secure as you can possibly be. In order to use Laravel to make a static site, I use `wget` to save a static version from the local server. The command looks like this:

```bash 
wget \
--directory-prefix=output/ \
--html-extension \
--convert-links \
--recursive \
--level=10 \
--page-requisites \
--timestamping \
--adjust-extension \
--no-host-directories \
http://localhost:8000
```

Here's an explanation of the options used:

+ `--directory-prefix`: Specifies the output directory.
+ `--html-extension`: Adds the .html extension to downloaded HTML files.
+ `--convert-links`: Converts the links to make them suitable for offline viewing.
+ `--recursive`: Enables recursive downloading.
+ `--level`: Sets the maximum recursion level to 10.
+ `--page-requisites`: Downloads all necessary files for displaying the page.
+ `--timestamping`: Only downloads files if they are newer.
+ `--adjust-extension`: Adjusts the file extension if necessary.
+ `--no-host-directories`: Disables the creation of host directories.

Not the prettiest build method, but, in my opinion, it's worth it to have complete control over my site.

After the `output` directory is built, I run `aws s3 sync ./output s3://chrisdempewolf.com --delete` to sync my S3 bucket.

## Conclusion

This certainly is not the most popular method for building static sites, but I like it, and it works for me.  For once, I feel like I am in complete control over all aspects of my site. I can easily add new features and change my site's layout or theme. Plus, I learned (and am learning) a lot.

And the IKEA effect is real.  I'm far prouder of this blog than I ever was of my blogs built on Hugo and Jekyll.

## Footnotes

[^1]: Blade makes this even easier. And you can still use raw PHP if you need.

[^2]: There are indeed PHP SSGs, but the whole reason I switched to PHP was to avoid off-the-shelf SSGs.

[^3]: Or they should be if your DB is properly normalized.

[^4]: It's convention in Laravel for model names to be singular, and table names to be plural (`Post` and `posts`). This makes sense, because a table holds many rows, while a model represents a single row from that table.

[^5]: If you want to see this live on your site, install the [DebugBar](https://github.com/barryvdh/laravel-debugbar) and click on the DB tab. It will show you all the queries made while fetching the current view!