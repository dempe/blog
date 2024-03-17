@extends('layout')

@section('title')
    About
@endsection
@section('content')
    <p>
        Hello! I'm Chris Dempewolf (dim-pee-wolf), software engineer and former ESL teacher.
    </p>
    <p>
        I'm from <a href="https://en.wikipedia.org/wiki/Fort_Smith,_Arkansas">Fort Smith</a>, Arkansas. I lived in Seattle for 2 years and abroad in Mexico, Japan, and Germany. I taught English for a couple of years and have worked as a software engineer for 7 years.
    </p>
    <p>
        This is what I look like:
    </p>
    <figure>
        <img src="/assets/img/me-selfie-cancun.jpg"
             alt="A selfie I took at a beach.  I squint as the sun shines brightly overhead.  I'm flanked by a palm tree."
             width="200"
             title="The author at a tropical Mexican beach"/>
        <figcaption>At the beach</figcaption>
    </figure>
    <figure>
        <img src="/assets/img/me-pacman.jpg"
             alt="Here, I'm playing Ms. PacMan on an arcade table in a dark Seattle bar. Turns out, they make arcade game tables so you can sit and do whatever while you play - in this case, drink a beer with a friend."
             width="200"
             title="The author playing Ms. PacMan"/>
        <figcaption>Playing Ms. PacMan</figcaption>
    </figure>
    <p>
        Thanks for stopping by!
    </p>
@endsection
