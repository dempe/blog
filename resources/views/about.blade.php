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



    {{--    <p>Some of my hobbies are ... </p>--}}

    {{--    <ul>--}}
    {{--        <li><strong>Dancing</strong> 🕺 (salsa, perreo, cumbia, bachata, merengue)</li>--}}
    {{--        <li><strong>Cooking</strong> 👨🏻‍🍳 (recipes <a href="/tags/recipes">here</a>)</li>--}}
    {{--        <li><strong>Eating</strong> 🍽️</li>--}}
    {{--        <li><strong>Computers</strong> 👨🏻‍💻(read my <a href="/tags/tech">posts about tech</a>)</li>--}}
    {{--        <li><strong>Running</strong> 🏃🏻‍♀️</li>--}}
    {{--        <li><strong>Reading</strong> 📚</li>--}}
    {{--        <li><strong>Video games</strong> 🎮</li>--}}
    {{--    </ul>--}}

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
