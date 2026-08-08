<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@hasSection('title')@yield('title') — @endif{{ config('app.name', 'Mading Digital') }}</title>
        <meta name="description" content="@yield('meta_description', 'Majalah dinding digital: menjelajahi perjalanan sekolah kita bersama.')">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=sora:400,600,700,800|plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen flex flex-col">
        <a href="#konten" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:rounded-lg focus:bg-navy-900 focus:text-white focus:text-sm">Langsung ke konten</a>

        @include('partials.nav')

        <main id="konten" class="flex-1">
            @yield('content')
        </main>

        @include('partials.footer')
        @include('partials.toast')
    </body>
</html>
