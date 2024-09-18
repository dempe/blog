@extends('layouts.dialogue')

@section('text')
    {{ $text }}
@endsection

@section('img')
    <img class="" src="../assets/img/cow.svg"
         alt="moo cow"
         title="Mu"/>
@endsection

@section('fig-caption')
    <a href="/about#mu">Mu</a>
@endsection
