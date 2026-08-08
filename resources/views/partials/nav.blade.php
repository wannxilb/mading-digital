<nav id="site-nav" class="fixed top-0 inset-x-0 z-40 transition-all duration-300">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="mt-3 sm:mt-4 flex items-center justify-between gap-3 rounded-2xl px-3 sm:px-5 py-2.5 transition-all duration-300">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group min-w-0">
                <span class="relative grid place-items-center size-10 sm:size-11 shrink-0 rounded-xl bg-gradient-to-br from-navy-800 to-royal-600 text-white shadow-glow">
                    <svg class="size-5 sm:size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 19a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2"/>
                        <path d="M5 17V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v12"/>
                        <path d="M9 8h6M9 12h4"/>
                    </svg>
                    <span class="absolute -right-1 -top-1 size-3 rounded-full bg-sky-400 animate-pulse-dot"></span>
                </span>
                <span class="min-w-0">
                    <span class="block font-display text-sm sm:text-base font-extrabold leading-tight tracking-tight text-navy-900">Mading Digital</span>
                    <span class="block text-[11px] sm:text-xs font-medium text-royal-600">Perjalanan Sekolah Kita</span>
                </span>
            </a>

            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-navy-900 hover:bg-ice-100 transition-colors">Beranda</a>
                <a href="{{ route('home') }}#pengumuman" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-navy-700 hover:bg-ice-100 transition-colors">Papan Info</a>
                <a href="{{ route('home') }}#prestasi" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-navy-700 hover:bg-ice-100 transition-colors">Prestasi</a>
                <a href="{{ route('home') }}#kegiatan" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-navy-700 hover:bg-ice-100 transition-colors">Kegiatan</a>
                <a href="{{ route('home') }}#karya" class="px-3.5 py-2 rounded-xl text-sm font-semibold text-navy-700 hover:bg-ice-100 transition-colors">Karya</a>
            </div>

            <div class="flex items-center gap-2">
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-2 rounded-xl bg-navy-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-navy-800 transition-colors">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                            Panel Admin
                        </a>
                    @else
                        <span class="hidden sm:inline-flex items-center gap-2 rounded-xl bg-ice-100 px-4 py-2.5 text-sm font-semibold text-navy-800">{{ auth()->user()->name }}</span>
                    @endif
                @else
                    <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-2 rounded-xl border border-navy-900/15 bg-white/70 px-4 py-2.5 text-sm font-semibold text-navy-900 hover:bg-white transition-colors">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="m10 17 5-5-5-5"/><path d="M15 12H3"/></svg>
                        Masuk Admin
                    </a>
                @endauth

                <button type="button" id="nav-toggle" class="lg:hidden grid place-items-center size-11 rounded-xl bg-white/70 border border-navy-900/15 text-navy-900" aria-label="Buka menu navigasi">
                    <svg id="icon-open" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg id="icon-close" class="size-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="lg:hidden hidden mt-2 mb-3 rounded-2xl bg-white/95 backdrop-blur-xl border border-navy-900/10 p-3 shadow-soft">
            <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold text-navy-900 hover:bg-ice-100">Beranda</a>
            <a href="{{ route('home') }}#pengumuman" class="block px-4 py-3 rounded-xl text-sm font-semibold text-navy-700 hover:bg-ice-100">Papan Info</a>
            <a href="{{ route('home') }}#prestasi" class="block px-4 py-3 rounded-xl text-sm font-semibold text-navy-700 hover:bg-ice-100">Prestasi</a>
            <a href="{{ route('home') }}#kegiatan" class="block px-4 py-3 rounded-xl text-sm font-semibold text-navy-700 hover:bg-ice-100">Kegiatan</a>
            <a href="{{ route('home') }}#karya" class="block px-4 py-3 rounded-xl text-sm font-semibold text-navy-700 hover:bg-ice-100">Karya</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="mt-1 block px-4 py-3 rounded-xl text-sm font-semibold bg-navy-900 text-white text-center">Panel Admin</a>
            @else
                <a href="{{ route('admin.login') }}" class="mt-1 block px-4 py-3 rounded-xl text-sm font-semibold bg-navy-900 text-white text-center">Masuk Admin</a>
            @endauth
        </div>
    </div>
</nav>
