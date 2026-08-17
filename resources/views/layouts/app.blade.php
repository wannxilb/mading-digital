<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@hasSection('title')@yield('title') — @endif{{ \App\Models\Setting::get('site_name', config('app.name', 'Mading Digital')) }}</title>
        <meta name="description" content="@yield('meta_description', \App\Models\Setting::get('site_description', 'Majalah dinding digital sekolah: pengumuman, berita, karya siswa, agenda, dan prestasi.'))">

        @php
            $favicon = \App\Models\Setting::get('favicon_path');
            $logo = \App\Models\Setting::get('logo_path');
        @endphp
        @if ($favicon)
            <link rel="icon" type="image/x-icon" href="{{ asset('storage/'.$favicon) }}">
        @endif

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700|inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col">
        <a href="#konten" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-brutal focus:border-2 focus:border-ink focus:bg-acid focus:px-4 focus:py-2 focus:text-sm focus:font-bold focus:text-ink">Langsung ke konten</a>

        @include('partials.nav')

        <main id="konten" class="flex-1">
            @yield('content')
        </main>

        @include('partials.footer')
        @include('partials.toast')
    </body>
</html>
