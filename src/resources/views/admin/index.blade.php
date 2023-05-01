<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('vendor/maybecms/fontawesome/css/all.min.css') }}" />
    <!-- Scripts -->
    @vite(['src/resources/sass/app.scss', 'src/resources/js/app.js'], 'vendor/maybecms/build')
</head>
<body>
<div id="app"></div>
@yield('scripts')
</body>
</html>
