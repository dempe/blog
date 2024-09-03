@extends('layout')
@section('title')
    About
@endsection
@section('content')
    <h2 id="me"><a href="#me">Me</a></h2>
    <div class="flex flex-col md:flex-row md:items-start">
        <div class="mx-auto w-1/2 md:-mt-4 md:-mx-4 md:order-first">
            <figure class="mx-0">
                <img src="../assets/img/me-selfie-cancun.webp"
                     alt="The author, hair dyed blue, standing in front of a palm tree, squinting due to the tropical sun."
                     width="200"
                     title="The author in Playa del Carmen"/>
                <figcaption>In Playa del Carmen</figcaption>
            </figure>
        </div>
        <div class="w-full order-first">
            <p>
                Hello! I'm Chris Dempewolf (dim-pee-wolf), software engineer, former ESL teacher, and, most recently,
                husband and father.
            </p>
            <p>
                I'm from <a target="_blank" href="https://en.wikipedia.org/wiki/Fort_Smith,_Arkansas">Fort Smith</a>,
                Arkansas. I lived in Seattle for 2 years and abroad in Mexico 🇲🇽, Japan 🇯🇵, and Germany 🇩🇪. I taught
                English for a couple of years and have worked as a software engineer for 7 years.
            </p>
            <p>
                I made this blog to explore my thoughts and practice my writing. I don't really know what I know until I
                write it, so this blog is meant to serve as my light in the dark.
            </p>
        </div>
    </div>
    <h2 id="the-title"><a href="#the-title">The Title</a></h2>
    <figure class="blockquote">
        <blockquote>
            <p>In the beginner's mind, there are many possibilities; in the expert's mind there are few.</p>
        </blockquote>
        <figcaption>Shunryu Suzuki, <em>Zen Mind, Beginner's Mind</em></figcaption>
    </figure>
    <p>This blog's title, <em>Shoshin</em>, is a Zen concept roughly translated as "beginner's mind", a concept first
        popularized in the West by Zen teacher <a target="_blank"
                                                  href="https://en.wikipedia.org/wiki/Shunry%C5%AB_Suzuki">Shunryu
            Suzuki</a> in his book, <em><a target="_blank"
                                           href="https://en.wikipedia.org/wiki/Zen_Mind,_Beginner's_Mind">Zen Mind,
                Beginner's Mind</a></em>. It implies curiosity, openness, and approaching things without preconceptions.
        It is the goal of this blog to explore many new and interesting topics—always through the eyes of a beginner.
    </p>
    <h2 id="the-characters"><a href="#the-characters">The Characters</a></h2>
    <h3 id="sho"><a href="#sho">Sho</a></h3>
    <div class="flex flex-col md:flex-row md:items-start">
        <div class="mx-auto w-1/2 md:-mt-4 md:-mx-4 md:order-first">
            <figure class="mx-0">
                <img src="../assets/img/cat-transparent.png"
                     alt="simple, cartoon, black cat, green eyes, smiling, black nose, pink mouth "
                     width="200"
                     title="Sho the Cat"/>
                <figcaption>Sho the Cat</figcaption>
            </figure>
        </div>
        <div class="w-full order-first">
            <p>
                Sho the Cat is a lively little fur ball. He's spontaneous, creative, and adventurous. He loves jokes and thrives in chaos. He's full of passion and lets his impulses guide him more than reason.
            </p>
            <p>
                Sho's Greek god is Dionysus. Sho is Mr. Hyde to Dr. Jekyll. Sho is Tyler Durden in <i>Fight Club</i>. Sho is System 1.
            </p>
        </div>
    </div>

@endsection
