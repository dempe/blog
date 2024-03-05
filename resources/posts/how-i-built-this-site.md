---
published: 1688601186
title: How I Built This Site
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

The only things PHP doesn't have are themes (I want to use my own CSS anyway 🤷🏻‍♂️) and a build command.[^1] Building's not a problem, either. I can use a simple `wget` incantation to pull down a static version of my site from the local server (see the section, "Building and Deployment").

PHP it is.

## Site Structure

I want to [keep things as simple as possible](https://en.wikipedia.org/wiki/KISS_principle). The home page (`chrisdempewolf.com`) is just a list of my posts. Posts are accessed under `chrisdempewolf.com/posts/{post}`. Same for tags. Aside from that, I have an about page and my resume (see links at top).

I had intended to have separate sections for notes (for shows, games, books, etc.) and recipes — two things I plan to blog a lot about. Then I realized that it would be simpler to just have a tag for each of these categories.

Most popular SSGs support some kind of draft feature. This is totally unnecessary in my opinion. I can just delegate to Git by checking out a new branch for each draft.

## Using a Relational Database For a Static Site

I have two entities — posts and tags. There is a many-to-many relationship between them. On my site, each tag has its own page that is dynamically generated with a list of all the posts associated with that tag, and for each post, there is a list of tags in the footer.

*This is actually pretty tricky to set up without a relational DB. With a relational DB, it's a piece of cake, and another reason I love my switch to PHP/Laravel.*

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

Each of these tables maps to a model in Laravel. I can then use Laravel's ORM, Eloquent.

The root directory of my site is just:

```PHP
Route::get('/', function () {
    return view('posts', ['posts' => Post::all()]);
});
```

A simple `SELECT *`. But what about the more complex relationships we discussed? For example, how can I get all posts for a tag? Here's the relevant portion from that route:

```PHP
$tag = Tag::findOrFail($query);
$posts = $tag->posts()->get();

return view('tag', ['tag' => $tag,
                    'posts' => $posts]);
```

One line! `$posts = $tag->posts()->get();` is all I need! 😎

To be fair, there was a bit of work I had to do on the models to make them aware of the relationships between posts, tags, and post_tags. Enter [Eloquent relationships](https://laravel.com/docs/10.x/eloquent-relationships).

<aside>My main reason for storing posts and tags in a database was to make it easy to track the relationships between them. You'll notice the body of the post has nothing to do with this. I considered not adding the body to the database, but I added it anyway for two reasons. One, it allows me to track update times for posts easily. Two, it's nice to have a single source for all of my data, as opposed to loading the post bodies from files and everything else from the database.</aside>

## Eloquent Relationships

Eloquent allows you to define relationships on your models via methods. It does this by providing various types associated with each type of relationship (one-to-one, one-to-many, many-to-many, etc.). To define a relationship, you need to implement a method on your model that returns the appropriate relationship type.

In my case, I implemented a method that returns `BelongsToMany` on both the `Post` model and the `Tag` model. Here's what that method looks like on the `Tag` model:

```PHP
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

There's a lot of parameters here, but it's not too bad. The first parameter to `belongsToMany` tells Eloquent that a `Tag` can have many `Post` s. The second parameter (`PostTag::class`) tells Eloquent that `Tag` s are related to `Post` s via `PostTag` (the `post_tags` table) AKA a "pivot table".[^3]

The remaining fields are IDs. You don't always have to explicitly pass IDs to Eloquent relation methods. I do, because I have custom ID fields for all my tables. The third parameter tells Eloquent that `tag` is the foreign key on the `post_tags` table. The fourth argument tells Eloquent that `slug` is the foreign key on the `posts_tags` table for `posts`. The fifth argument tells Eloquent that `tag` is the key for the `tags` table. Finally, the sixth argument tells Eloquent that `slug` is the key for the `posts` table.

All this allows me to use that nice chain syntax from above. Again, because it's so beautiful: `$posts = $tag->posts()->get();`.

But that's not all. It also allows for something called "**eager loading**".

## Avoiding N+1 with Eager Loading

Eager loading is Eloquent's way of averting the N+1 query problem. Here's how you use it.

Say I have the following code:

```PHP
$posts = Post::all();

foreach ($posts as $post) {
    foreach ($post->tags as $tag) {
        echo $tag->name;
    }
}
```

This results in N+1 queries — 1 to fetch all posts and N to fetch the tags for each post. If we we querying the DB directly, we would just do a `join`, but Eloquent has no idea that we are going to fetch the tags for each post when we call `Post::all();`. This is, in fact, a common problem with all ORMs.

Now that we've defined our relationships on each model, we can *tell* Eloquent that we are going to fetch each post's tags (i.e, use eager loading).

```PHP
$posts = Post::with('tags')->get();

foreach ($posts as $post) {
    foreach ($post->tags as $tag) {
        echo $tag->name;
    }
}
```

The key thing to note here is `::with('tags')`. This makes Eloquent eagerly load the tags along with the posts. Instead of running N+1 queries, we're now only running 1 query![^4]

Eloquent does this by attaching an array of `Tag` s to each `Post` when you call `Post::with('tags')->get()`. You can see this by running `php artisan tinker` and comparing the two outputs — lazy and eager.

## Seeding and Migrations

As mentioned, I store all of my posts in a database (Sqlite, specifically). This allows me to easily handle the many-to-many relationship between posts and tags. But I need to actually import the posts.

I realize it's probably a huge anti-pattern, but so far I've been using DB seeders for this purpose. Aside from using seeders for something other than their intended purpose, another downside is that I need to run `php artisan db:seed` every time I update a post for that update to be reflected on the server.

Instead, I plan to create a custom `artisan` command to import my posts. This will at least remove the anti-pattern of using seeders to import my posts.

I have pretty standard migrations for each table, `posts`, `tags`, and `post_tags`. The only hiccup was that I needed to use raw SQL (via the `DB::statement` method) on the `posts` table. Sqlite doesn't have `ON UPDATE CURRENT_TIMESTAMP` like in MySQL. Instead, I had to create a trigger:

```php
DB::statement('CREATE TRIGGER update_post_updated_at UPDATE ON posts
                BEGIN
                    UPDATE posts SET updated_at = CURRENT_TIMESTAMP WHERE OLD.slug = NEW.slug;
                END;');
```

Doing this allows me to track when posts were last updated, which I display in the post's footer.

## Creating a New Post

I made a custom Artisan command to make a new post: `php artisan make:post <title> <tags>`. For this post, I ran `php artisan make:post "How I Built This Site" "tech php"`. This slugifys the title and creates a new file, `resources/posts/how-i-built-this-site.md`.

After the new post has been imported to the DB, I can go to the URL `<host>/posts/how-i-built-this-site`. This is what the route looks like:

```php
Route::get('/posts/{post}', function ($slug) {
    try {
        return view('post', ['post' => Post::findOrFail($slug),
                             'tags' => PostTag::where('slug', $slug)->pluck('tag')]);
    }
    catch (ModelNotFoundException $e) {
        return response()->view('404', [], ResponseAlias::HTTP_NOT_FOUND);
    }
});
```

It loads the `post` view, which is a Blade template:

```php-template
@extends('layout')

@php
    $pd = new ParsedownExtra();
@endphp

@section('title')
    {{ $post->title }}
@endsection
@section('content')
    {!! $pd->text($post->body) !!}
@endsection
```

I initialize `ParsedownExtra` to parse the Markdown here. It didn't make sense to add display logic in my routes file.

And that's it!

## Building and Deployment

I want a static site. Hosting them is cheap (free), and as fast and secure as you can possibly be. In order to use Laravel to make a static site, I use `wget` to pull down a static version from the local server. The command looks like this:

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

Not the pretties build method, but, in my opinion, it's worth it to use Laravel to build my static site.

After the `output` directory is built, I run `aws s3 sync ./output s3://chrisdempewolf.com --delete` to sync my S3 bucket.

## Conclusion

This certainly is not the most popular method for building static sites, but I like it, and it works for me.  For once, I feel like I am in complete control over all aspects of my site.  And working with Laravel is a sheer pleasure.  If you are a PHP and/or Laravel fan, give it a try!

## Footnotes

[^1]: There are indeed PHP SSGs, but the whole reason I switched to PHP was to avoid off-the-shelf SSGs.

[^2]: Or they should be if your DB is properly normalized.

[^3]: It's convention in Laravel for model names to be singular, and table names to be plural (`Post` and `posts`). This makes sense, because a table holds many rows, while a model represents a single row from that table.

[^4]: If you want to see this live on your site, install the [DebugBar](https://github.com/barryvdh/laravel-debugbar) and click on the DB tab. It will show you all the queries made while fetching the current view!
