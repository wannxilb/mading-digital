<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@hasSection('title')@yield('title') — @endif{{ config('app.name', 'Mading Digital') }} · Admin</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=sora:400,600,700,800|plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-ice-50">
        @if (auth()->check())
            <div class="flex min-h-screen">
                <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full bg-navy-900 text-white transition-transform duration-300 lg:translate-x-0 lg:static lg:sticky lg:top-0 lg:h-screen">
                    <div class="flex h-full flex-col">
                        <div class="flex items-center gap-3 px-6 py-5">
                            <span class="grid place-items-center size-10 rounded-xl bg-gradient-to-br from-sky-500 to-royal-600 text-white">
                                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 19a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2"/><path d="M5 17V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v12"/><path d="M9 8h6M9 12h4"/></svg>
                            </span>
                            <div>
                                <p class="font-display font-extrabold text-sm leading-tight">Mading Digital</p>
                                <p class="text-[11px] text-white/50 font-medium">Panel Admin</p>
                            </div>
                        </div>

                        <nav class="mt-4 flex-1 space-y-1 px-3">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                                <x-icon name="layout" class="size-5"/>
                                Dashboard
                            </a>
                            <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                                <x-icon name="folder" class="size-5"/>
                                Kelola Konten
                                <span class="ml-auto rounded-full bg-sky-500/20 px-2 py-0.5 text-[10px] font-bold text-sky-300">{{ App\Models\Post::count() }}</span>
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' }}">
                                <x-icon name="grid" class="size-5"/>
                                Kategori
                                <span class="ml-auto rounded-full bg-sky-500/20 px-2 py-0.5 text-[10px] font-bold text-sky-300">{{ App\Models\Category::count() }}</span>
                            </a>
                            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition-colors text-white/60 hover:bg-white/5 hover:text-white">
                                <x-icon name="home" class="size-5"/>
                                Lihat Papan Publik
                            </a>
                        </nav>

                        <div class="border-t border-white/10 p-3">
                            <div class="flex items-center gap-3 rounded-xl px-3 py-2.5">
                                <span class="grid place-items-center size-9 shrink-0 rounded-full bg-sky-500/20 text-sky-300 text-xs font-bold">{{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}</span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-bold text-white">{{ auth()->user()->name }}</p>
                                    <p class="truncate text-[11px] text-white/50">Administrator</p>
                                </div>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="grid place-items-center size-8 rounded-lg text-white/60 hover:bg-white/10 hover:text-white transition-colors" title="Keluar">
                                        <x-icon name="logout" class="size-4"/>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </aside>

                <div class="flex min-w-0 flex-1 flex-col">
                    <header class="sticky top-0 z-30 flex items-center gap-4 border-b border-navy-900/5 bg-white/80 backdrop-blur-xl px-4 sm:px-8 py-4">
                        <button type="button" id="admin-nav-toggle" class="lg:hidden grid place-items-center size-10 rounded-xl bg-ice-100 text-navy-900" aria-label="Buka menu">
                            <x-icon name="menu" class="size-5"/>
                        </button>
                        <div class="min-w-0">
                            <h1 class="truncate font-display font-extrabold text-lg text-navy-900">@yield('heading', 'Dashboard')</h1>
                            <p class="hidden sm:block text-xs font-medium text-navy-900/50">{{ now()->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <a href="{{ route('admin.posts.create') }}" class="ml-auto inline-flex shrink-0 items-center gap-2 rounded-xl bg-gradient-to-br from-navy-800 to-royal-600 px-4 py-2.5 text-xs sm:text-sm font-bold text-white shadow-glow hover:opacity-95 transition-opacity">
                            <x-icon name="plus" class="size-4"/>
                            <span class="hidden sm:inline">Tulis Cerita</span>
                        </a>
                    </header>

                    <main class="flex-1 px-4 sm:px-8 py-6 sm:py-8">
                        @yield('content')
                    </main>
                </div>
            </div>

            @include('partials.toast')
        @else
            @yield('content')
        @endif
    </body>
</html>
