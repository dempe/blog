@extends('layout')

@section('title')
    About
@endsection
@section('content')
    <p>
        Hello! I'm Chris Dempewolf (dim-pee-wolf), software engineer and former ESL teacher.
    </p>

    <aside>
        <figure>
            <img src="/assets/img/me-selfie-cancun.jpg"
                 alt="A selfie I took in Cancún.  I squint as the sun shines brightly overhead.  There is a palm tree behind me."
                 width="200"
                 title="The author in Cancún"/>
            <figcaption>The author in Cancún</figcaption>
        </figure>
    </aside>

    <p>
        I was born in the Fort Smith, Arkansas, USA. I lived in Seattle for 2 years and
        abroad in Mexico, Japan, and Germany. I taught English for a couple of years and have worked as a software
        engineer
        for 7 years.
    </p>


    <p>Some of my hobbies are ... </p>

    <ul>
        <li><strong>Dancing</strong> 🕺 (salsa, perreo, cumbia, bachata)</li>
        <li><strong>Cooking</strong> 👨🏻‍🍳</li>
        <li><strong>Eating</strong> 🍽️</li>
        <li><strong>Computers</strong> 👨🏻‍💻</li>
        <li><strong>Running</strong> 🏃🏻‍♀️</li>
        <li><strong>Reading</strong> 📚</li>
        <li><strong>Video games</strong> 🎮</li>
    </ul>

    <aside>
        <figure>
            <img src="/assets/img/me-pacman.jpg"
                 alt="Here, I'm playing Ms. PacMan on an arcade table in a dark Seattle bar. Turns out, they make arcade game tables so you can sit and do whatever.  In this case, drink a beer with a friend."
                 width="200"
                 title="The author playing Ms. PacMan"/>
            <figcaption>The author playing Ms. PacMan</figcaption>
        </figure>
    </aside>

    <p>
        I write about computation, biology, cooking, and everything else that piques my interest. Post archive <a
            href="/index.php">here</a>.
    </p>

    <p>Thanks for stopping by!</p>
@endsection
@section('footer-content')
    <div class="footer-content">
        <table>
            <tr>
                <td class="table-key">Published:&nbsp;&nbsp;</td>
                <td>2023-02-27 00:18</td>
            </tr>
            <tr>
                <td class="table-key">Updated:&nbsp;&nbsp;</td>
                <td>{{ Carbon\Carbon::createFromTimestamp(filemtime(resource_path('views/about.blade.php')))->format('Y-m-d H:i') }}</td>
            </tr>
        </table>
    </div>
@endsection
