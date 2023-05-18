@extends('layout')

@section('title')
    {{ $title }}
@endsection
@section('content')
    <p>
        This page doesn't exist!
    </p>
    <p>
        The URL you specified was <code>{{ url()->current() }}</code>. If that looks fine, and it's still not working, start from
        the <a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/index.php">site index</a> and see if you can find what you're looking for.
    </p>
@endsection
