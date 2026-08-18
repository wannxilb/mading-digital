<nav id="site-nav" class="fixed inset-x-0 top-0 z-40">
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="mt-0 flex items-center justify-between gap-4 px-3 sm:px-4 transition-all duration-300">
            <a href="{{ route('home') }}" class="group flex min-w-0 items-center gap-3 py-4">
                @php $logo = \App\Models\Setting::get('logo_path'); @endphp
                @if ($logo)
                    <img src="{{ asset('storage/'.$logo) }}" alt="Logo" class="size-10 shrink-0 rounded-brutal border-2 border-ink object-contain bg-cream">
                @else
                    <span class="grid size-10 shrink-0 place-items-center rounded-brutal border-2 border-ink bg-blue font-display text-lg font-bold text-cream transition-transform duration-150 group-hover:-translate-y-0.5">
                        MD
                    </span>
                @endif
                <span class="min-w-0">
                    <span class="block font-display text-base font-bold leading-tight tracking-tight text-ink">{{ \App\Models\Setting::get('site_name', 'Mading Digital') }}</span>
                    <span class="block text-[11px] font-semibold uppercase tracking-[0.18em] text-ink-3">{{ \App\Models\Setting::get('site_tagline', 'Majalah Dinding Sekolah') }}</span>
                </span>
            </a>

            <div class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('home') }}" class="rounded-brutal px-3.5 py-2 text-sm font-bold text-ink transition-colors hover:bg-blue hover:text-cream {{ request()->routeIs('home') ? 'bg-blue text-cream' : '' }}">Beranda</a>
                <a href="{{ route('berita.index') }}" class="rounded-brutal px-3.5 py-2 text-sm font-bold text-ink transition-colors hover:bg-blue hover:text-cream {{ request()->routeIs('berita.*') ? 'bg-blue text-cream' : '' }}">Berita</a>
                <a href="{{ route('artikel.index') }}" class="rounded-brutal px-3.5 py-2 text-sm font-bold text-ink transition-colors hover:bg-blue hover:text-cream {{ request()->routeIs('artikel.*') ? 'bg-blue text-cream' : '' }}">Artikel</a>
                <a href="{{ route('agenda.index') }}" class="rounded-brutal px-3.5 py-2 text-sm font-bold text-ink transition-colors hover:bg-blue hover:text-cream {{ request()->routeIs('agenda.*') ? 'bg-blue text-cream' : '' }}">Agenda</a>
                <a href="{{ route('prestasi.index') }}" class="rounded-brutal px-3.5 py-2 text-sm font-bold text-ink transition-colors hover:bg-blue hover:text-cream {{ request()->routeIs('prestasi.*') ? 'bg-blue text-cream' : '' }}">Prestasi</a>
                <a href="{{ route('pengumuman.index') }}" class="rounded-brutal px-3.5 py-2 text-sm font-bold text-ink transition-colors hover:bg-blue hover:text-cream {{ request()->routeIs('pengumuman.*') ? 'bg-blue text-cream' : '' }}">Pengumuman</a>
                <a href="{{ route('tentang') }}" class="rounded-brutal px-3.5 py-2 text-sm font-bold text-ink transition-colors hover:bg-blue hover:text-cream {{ request()->routeIs('tentang') ? 'bg-blue text-cream' : '' }}">Tentang</a>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('cari.index') }}" class="hidden sm:grid size-10 place-items-center rounded-brutal border-2 border-ink text-ink transition-all duration-150 hover:bg-blue hover:text-cream" aria-label="Cari konten">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                </a>

                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn-ink hidden sm:inline-flex">
                            <x-icon name="layout" class="size-4"/>
                            Panel Admin
                        </a>
                    @elseif (auth()->user()->isSiswa())
                        <a href="{{ route('siswa.dashboard') }}" class="btn-ink hidden sm:inline-flex">
                            <x-icon name="layout" class="size-4"/>
                            Portal Siswa
                        </a>
                    @else
                        <div class="hidden items-center gap-2 sm:flex">
                            <span class="inline-flex items-center gap-2 rounded-brutal border-2 border-ink bg-cream px-4 py-2 text-sm font-bold text-ink">
                                {{ auth()->user()->name }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="grid size-10 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-accent hover:text-cream" title="Keluar" aria-label="Keluar">
                                    <x-icon name="logout" class="size-4"/>
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <a href="{{ route('admin.login') }}" class="btn-outline hidden sm:inline-flex">
                        Masuk
                        <x-icon name="arrow-right" class="size-4"/>
                    </a>
                @endauth

                <button type="button" id="nav-toggle" class="grid size-10 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink lg:hidden" aria-label="Buka menu navigasi" aria-expanded="false">
                    <svg id="icon-open" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg id="icon-close" class="hidden size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="mb-3 hidden rounded-brutal border-2 border-ink bg-cream p-3 shadow-brutal-sm lg:hidden">
            <div class="grid grid-cols-2 gap-1.5">
                <a href="{{ route('home') }}" class="rounded-brutal bg-paper px-4 py-3 text-sm font-bold text-ink {{ request()->routeIs('home') ? 'bg-blue text-cream' : '' }}">Beranda</a>
                <a href="{{ route('berita.index') }}" class="rounded-brutal bg-paper px-4 py-3 text-sm font-bold text-ink {{ request()->routeIs('berita.*') ? 'bg-blue text-cream' : '' }}">Berita</a>
                <a href="{{ route('artikel.index') }}" class="rounded-brutal bg-paper px-4 py-3 text-sm font-bold text-ink {{ request()->routeIs('artikel.*') ? 'bg-blue text-cream' : '' }}">Artikel</a>
                <a href="{{ route('agenda.index') }}" class="rounded-brutal bg-paper px-4 py-3 text-sm font-bold text-ink {{ request()->routeIs('agenda.*') ? 'bg-blue text-cream' : '' }}">Agenda</a>
                <a href="{{ route('prestasi.index') }}" class="rounded-brutal bg-paper px-4 py-3 text-sm font-bold text-ink {{ request()->routeIs('prestasi.*') ? 'bg-blue text-cream' : '' }}">Prestasi</a>
                <a href="{{ route('pengumuman.index') }}" class="rounded-brutal bg-paper px-4 py-3 text-sm font-bold text-ink {{ request()->routeIs('pengumuman.*') ? 'bg-blue text-cream' : '' }}">Pengumuman</a>
                <a href="{{ route('tentang') }}" class="rounded-brutal bg-paper px-4 py-3 text-sm font-bold text-ink {{ request()->routeIs('tentang') ? 'bg-blue text-cream' : '' }}">Tentang</a>
            </div>
            <div class="mt-2 grid gap-1.5 border-t-2 border-ink/10 pt-3">
                <a href="{{ route('cari.index') }}" class="rounded-brutal bg-paper px-4 py-3 text-sm font-bold text-ink">Cari Konten</a>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn-ink">Panel Admin</a>
                    @elseif (auth()->user()->isSiswa())
                        <a href="{{ route('siswa.dashboard') }}" class="btn-ink">Portal Siswa</a>
                    @else
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-ink w-full">
                                Keluar
                                <x-icon name="logout" class="size-4"/>
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('admin.login') }}" class="btn-ink">Masuk</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
