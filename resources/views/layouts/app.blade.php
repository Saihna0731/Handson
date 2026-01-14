<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    @if (env('USE_CDN_ASSETS', false))
        <script src="https://cdn.tailwindcss.com"></script>
        <style>[x-cloak]{display:none !important;}</style>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script defer src="{{ asset('js/book-page.js') }}"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @stack('head')
</head>
<body class="min-h-screen overflow-x-hidden bg-slate-50 text-slate-900">
    @yield('content')
</body>
</html>
