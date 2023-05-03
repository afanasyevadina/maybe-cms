<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $metaTitle ?? maybe_setting('site_name') }}</title>
    <meta name="description" content="{{ $metaDescription ?? '' }}">
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:image" content="{{ $ogImage ?? '' }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/maybecms/themes/' . maybe_setting('active_theme') . '/style.css') }}">
    <script src="{{ asset('vendor/maybecms/themes/' . maybe_setting('active_theme') . '/script.js') }}" defer></script>
</head>
<body>
@yield('content')
</body>
</html>
