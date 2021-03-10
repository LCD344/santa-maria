<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ request()->session()->token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="{{ $manifestFile->{'/css/app.css'} }}" rel="stylesheet">


</head>
<body>
<div id="app">
    <app :initial-matches="{{ $matches }}"></app>
</div>

<script src="{{$manifestFile->{'/js/app.js'} }}"></script>
</body>
</html>
