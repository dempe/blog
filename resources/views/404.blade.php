@extends('layouts.layout')

@section('title')
    404
@endsection
@section('content')
    <p id="404-message"></p>
    <script>
        const p = document.getElementById('404-message');
        const codeNode = document.createElement('code');

        codeNode.textContent = window.location.href;
        p.appendChild(document.createTextNode('The URL you entered ('));
        p.appendChild(codeNode);
        p.appendChild(document.createTextNode(') does not exist on this site.'));
    </script>
@endsection