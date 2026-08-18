<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@hasSection('title')@yield('title') — @endif{{ config('app.name', 'Mading Digital') }} · Siswa</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700|inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-paper">
        <div class="flex min-h-screen">
            <aside id="siswa-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full border-r-2 border-ink bg-ink text-cream transition-transform duration-300 lg:translate-x-0 lg:static lg:sticky lg:top-0 lg:h-screen">
                <div class="flex h-full flex-col">
                    <div class="flex items-center gap-3 border-b-2 border-cream/15 px-5 py-5">
                        <span class="grid size-10 shrink-0 place-items-center rounded-brutal border-2 border-cream bg-accent font-display text-lg font-bold text-cream">
                            MD
                        </span>
                        <div class="min-w-0">
                            <p class="font-display text-sm font-bold leading-tight">Mading Digital</p>
                            <p class="text-[11px] font-semibold uppercase tracking-widest text-cream/50">Portal Siswa</p>
                        </div>
                    </div>

                    <nav class="mt-4 flex-1 space-y-1 overflow-y-auto px-3">
                        <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-3 rounded-brutal px-4 py-2.5 text-sm font-bold transition-colors {{ request()->routeIs('siswa.dashboard') ? 'bg-acid text-ink' : 'text-cream/70 hover:bg-cream/10 hover:text-cream' }}">
                            <x-icon name="layout" class="size-4.5"/>
                            Dashboard
                        </a>
                        <div class="relative" data-dropdown>
                            <button type="button" data-dropdown-toggle class="flex w-full items-center gap-3 rounded-brutal px-4 py-2.5 text-sm font-bold transition-colors {{ request()->routeIs('siswa.karya.*') ? 'bg-acid text-ink' : 'text-cream/70 hover:bg-cream/10 hover:text-cream' }}">
                                <x-icon name="pen" class="size-4.5"/>
                                Karya Saya
                                <x-icon name="chevron-down" class="ml-auto size-4 transition-transform"/>
                            </button>
                            <div data-dropdown-menu class="hidden fixed z-50 mt-1 w-56 rounded-brutal border-2 border-cream/20 bg-ink p-1">
                                <a href="{{ route('siswa.karya.index') }}" class="flex items-center gap-3 rounded-brutal px-3 py-2 text-sm font-bold text-cream/70 transition-colors hover:bg-cream/10 hover:text-cream">
                                    <x-icon name="book-open" class="size-4"/>
                                    Lihat Karya
                                </a>
                                <a href="{{ route('siswa.karya.create') }}" class="flex items-center gap-3 rounded-brutal px-3 py-2 text-sm font-bold text-cream/70 transition-colors hover:bg-cream/10 hover:text-cream">
                                    <x-icon name="plus" class="size-4"/>
                                    Tulis Karya
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-brutal px-4 py-2.5 text-sm font-bold transition-colors text-cream/70 hover:bg-cream/10 hover:text-cream">
                            <x-icon name="globe" class="size-4.5"/>
                            Lihat Situs Publik
                        </a>
                        <a href="{{ route('siswa.profil.edit') }}" class="flex items-center gap-3 rounded-brutal px-4 py-2.5 text-sm font-bold transition-colors {{ request()->routeIs('siswa.profil.*') ? 'bg-acid text-ink' : 'text-cream/70 hover:bg-cream/10 hover:text-cream' }}">
                            <x-icon name="users" class="size-4.5"/>
                            Edit Profil
                        </a>
                    </nav>

                    <div class="border-t-2 border-cream/15 p-3">
                        <div class="flex items-center gap-3 rounded-brutal border-2 border-cream/20 bg-cream/5 px-3 py-2.5">
                            <span class="grid size-9 shrink-0 place-items-center rounded-brutal bg-acid font-display text-sm font-bold text-ink">{{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}</span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-bold text-cream">{{ auth()->user()->name }}</p>
                                <p class="truncate text-[11px] text-cream/50">{{ auth()->user()->jurusan_label ?? auth()->user()->class ?? 'Siswa' }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="grid size-8 place-items-center rounded-brutal border-2 border-cream/30 text-cream/70 transition-colors hover:bg-accent hover:text-cream" title="Keluar">
                                    <x-icon name="logout" class="size-4"/>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="flex min-w-0 flex-1 flex-col">
                <header class="sticky top-0 z-30 flex items-center gap-4 border-b-2 border-ink bg-paper/90 px-4 py-4 backdrop-blur sm:px-8">
                    <button type="button" id="admin-nav-toggle" class="grid size-10 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink lg:hidden" aria-label="Buka menu">
                        <x-icon name="menu" class="size-5"/>
                    </button>
                    <div class="min-w-0">
                        <h1 class="truncate font-display text-xl font-bold text-ink">@yield('heading', 'Dashboard')</h1>
                        <p class="hidden text-xs font-semibold text-ink-3 sm:block">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="ml-auto flex shrink-0 items-center gap-2">
                    </div>
                </header>

                <main class="flex-1 px-4 py-6 sm:px-8 sm:py-8">
                    @yield('content')
                </main>
            </div>
        </div>

        @include('partials.toast')

        <script>
            const toggle = document.getElementById('admin-nav-toggle');
            const sidebar = document.getElementById('siswa-sidebar');
            if (toggle && sidebar) {
                toggle.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
            }

            document.querySelectorAll('[data-dropdown]').forEach((dropdown) => {
                const btn = dropdown.querySelector('[data-dropdown-toggle]');
                const menu = dropdown.querySelector('[data-dropdown-menu]');
                const chevron = btn.querySelector('svg:last-child');
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isOpen = !menu.classList.contains('hidden');
                    if (!isOpen) {
                        const rect = btn.getBoundingClientRect();
                        menu.style.left = rect.left + 'px';
                        menu.style.top = rect.bottom + 'px';
                        menu.style.width = rect.width + 'px';
                    }
                    menu.classList.toggle('hidden');
                    chevron?.classList.toggle('rotate-180');
                });
            });
        </script>
    </body>
</html>
