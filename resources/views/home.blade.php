@extends('layouts.app')

@section('title', 'Majalah Dinding Sekolah')
@section('meta_description', 'Menjelajahi pengumuman, prestasi, kegiatan, dan karya dalam perjalanan sekolah kita.')

@section('content')
    <div class="pt-24 sm:pt-28">
        {{-- HERO — Titik Awal Perjalanan --}}
        <section class="relative overflow-hidden bg-white">
            <div class="absolute inset-0 bg-grid-blue"></div>
            <div class="absolute -top-24 -right-24 size-96 rounded-full bg-royal-500/10 blur-3xl"></div>
            <div class="absolute top-40 -left-32 size-80 rounded-full bg-sky-400/10 blur-3xl"></div>

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6 py-16 sm:py-24">
                <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-8">

                    <div class="lg:col-span-7">
                        <span class="reveal inline-flex items-center gap-2 rounded-full bg-ice-100 px-3.5 py-1.5 text-xs font-bold text-royal-600 ring-1 ring-royal-500/20">
                            <span class="size-2 rounded-full bg-royal-600 animate-pulse-dot"></span>
                            Papan perjalanan sekolah kita
                        </span>

                        <h1 class="reveal mt-5 font-display text-4xl font-extrabold leading-[1.08] tracking-tight text-navy-900 text-balance sm:text-5xl lg:text-6xl" style="transition-delay:.05s">
                            Setiap langkah di sekolah adalah <span class="text-transparent bg-clip-text bg-gradient-to-r from-navy-800 via-royal-600 to-sky-500">cerita yang layak dibaca.</span>
                        </h1>

                        <p class="reveal mt-5 max-w-xl text-base sm:text-lg leading-relaxed text-navy-900/60" style="transition-delay:.1s">
                            Selamat datang di mading digital. Jelajahi pengumuman, prestasi, kegiatan, dan karya — dari gerbang masuk hingga langkah terakhir kita di sekolah.
                        </p>

                        <div class="reveal mt-8 flex flex-col sm:flex-row gap-3" style="transition-delay:.15s">
                            <a href="#semua" class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-br from-navy-800 to-royal-600 px-6 py-4 text-sm font-bold text-white shadow-glow transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lift">
                                Mulai Menjelajah
                                <x-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-1"/>
                            </a>
                            <a href="{{ route('home') }}#pengumuman" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-4 text-sm font-bold text-navy-900 ring-1 ring-navy-900/10 transition-all duration-300 hover:ring-royal-500/40 hover:shadow-soft">
                                <x-icon name="map-pin" class="size-4 text-royal-600"/>
                                Lihat Papan Info
                            </a>
                        </div>

                        <div class="reveal mt-10 grid grid-cols-3 gap-4 sm:gap-6 max-w-md" style="transition-delay:.2s">
                            <div class="rounded-2xl bg-ice-50 ring-1 ring-navy-900/5 p-3.5 sm:p-4">
                                <p class="font-display text-2xl sm:text-3xl font-extrabold text-navy-900" data-count="{{ $totalPosts }}">0</p>
                                <p class="mt-1 text-[11px] sm:text-xs font-semibold text-navy-900/50">Cerita diterbitkan</p>
                            </div>
                            <div class="rounded-2xl bg-ice-50 ring-1 ring-navy-900/5 p-3.5 sm:p-4">
                                <p class="font-display text-2xl sm:text-3xl font-extrabold text-navy-900" data-count="{{ $totalViews }}">0</p>
                                <p class="mt-1 text-[11px] sm:text-xs font-semibold text-navy-900/50">Kali dibaca</p>
                            </div>
                            <div class="rounded-2xl bg-ice-50 ring-1 ring-navy-900/5 p-3.5 sm:p-4">
                                <p class="font-display text-2xl sm:text-3xl font-extrabold text-navy-900" data-count="{{ $categories->count() }}">0</p>
                                <p class="mt-1 text-[11px] sm:text-xs font-semibold text-navy-900/50">Halte perjalanan</p>
                            </div>
                        </div>
                    </div>

                    {{-- JOURNEY PATH ARTWORK --}}
                    <div class="lg:col-span-5 reveal" style="transition-delay:.1s">
                        <div class="relative mx-auto max-w-sm">
                            <svg viewBox="0 0 400 460" class="w-full h-auto" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path id="journey-path" d="M80 420 C 60 360, 120 340, 100 280 S 180 210, 160 150 S 250 110, 240 60" stroke="#3b82f6" stroke-width="3" stroke-dasharray="1 10" stroke-linecap="round" opacity="0.45"/>

                                <g id="pin-1">
                                    <circle cx="80" cy="420" r="18" fill="#0b1b3f"/>
                                    <circle cx="80" cy="420" r="7" fill="#38bdf8" class="animate-pulse-dot"/>
                                </g>
                                <g id="pin-2">
                                    <circle cx="100" cy="280" r="16" fill="#1d4ed8"/>
                                    <circle cx="100" cy="280" r="6" fill="#fff"/>
                                </g>
                                <g id="pin-3">
                                    <circle cx="160" cy="150" r="16" fill="#2563eb"/>
                                    <circle cx="160" cy="150" r="6" fill="#fff"/>
                                </g>
                                <g id="pin-4">
                                    <circle cx="240" cy="60" r="20" fill="#0ea5e9"/>
                                    <circle cx="240" cy="60" r="8" fill="#fff"/>
                                    <circle cx="240" cy="60" r="12" fill="none" stroke="#fff" opacity="0.6"/>
                                </g>
                            </svg>

                            <div class="absolute top-[8%] -right-2 sm:right-0 rounded-2xl bg-white shadow-soft ring-1 ring-navy-900/5 px-4 py-2.5 animate-float">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-navy-900/40">Halte 1</p>
                                <p class="text-xs font-bold text-navy-900">Papan Info</p>
                            </div>
                            <div class="absolute top-[38%] -left-3 sm:left-0 rounded-2xl bg-white shadow-soft ring-1 ring-navy-900/5 px-4 py-2.5 animate-float" style="animation-delay:1.2s">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-navy-900/40">Halte 2</p>
                                <p class="text-xs font-bold text-navy-900">Prestasi</p>
                            </div>
                            <div class="absolute top-[64%] -right-2 sm:right-2 rounded-2xl bg-white shadow-soft ring-1 ring-navy-900/5 px-4 py-2.5 animate-float" style="animation-delay:.6s">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-navy-900/40">Halte 3</p>
                                <p class="text-xs font-bold text-navy-900">Kegiatan</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEARCH --}}
                <form method="GET" action="{{ route('home') }}" class="reveal mx-auto mt-14 max-w-2xl" style="transition-delay:.25s">
                    <div class="relative">
                        <x-icon name="search" class="pointer-events-none absolute left-5 top-1/2 size-5 -translate-y-1/2 text-navy-900/35"/>
                        <input
                            type="search"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Cari pengumuman, prestasi, kegiatan, atau karya..."
                            class="w-full rounded-2xl border-0 bg-white py-4 pl-13 pr-28 text-sm font-medium text-navy-900 shadow-soft ring-1 ring-navy-900/10 placeholder:text-navy-900/35 focus:outline-none focus:ring-2 focus:ring-royal-500 transition-shadow"
                        >
                        <button type="submit" class="absolute right-2.5 top-1/2 -translate-y-1/2 rounded-xl bg-navy-900 px-5 py-2.5 text-xs font-bold text-white hover:bg-navy-800 transition-colors">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </section>

        {{-- MARQUEE — berita berjalan --}}
        @if ($posts->isNotEmpty())
            <div class="border-y border-navy-900/10 bg-navy-900 py-3.5 overflow-hidden">
                <div class="flex w-max animate-marquee gap-12 whitespace-nowrap" id="marquee">
                    @foreach (collect()->pad(3, null) as $i)
                        @foreach ($posts->take(6) as $post)
                            <a href="{{ route('post.show', $post) }}" class="inline-flex items-center gap-3 text-sm font-semibold text-white/80 hover:text-white transition-colors">
                                <x-icon name="sparkle" class="size-3.5 text-sky-400"/>
                                {{ $post->title }}
                            </a>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif

        {{-- HALTE UTAMA — konten unggulan --}}
        @if ($featured)
            <section class="mx-auto max-w-6xl px-4 sm:px-6 py-16 sm:py-20">
                <div class="reveal grid gap-8 lg:grid-cols-2 lg:gap-12 items-center overflow-hidden rounded-3xl bg-gradient-to-br from-navy-900 via-navy-800 to-royal-700 p-8 sm:p-12 text-white shadow-lift relative">
                    <div class="absolute inset-0 bg-grid-blue opacity-20"></div>
                    <div class="absolute -top-20 -right-20 size-72 rounded-full bg-sky-400/20 blur-3xl"></div>

                    <div class="relative">
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3.5 py-1.5 text-xs font-bold backdrop-blur">
                            <x-icon name="trophy" class="size-3.5 text-sky-400"/>
                            Cerita Unggulan Pekan Ini
                        </span>
                        <h2 class="mt-5 font-display text-3xl sm:text-4xl font-extrabold leading-tight text-balance">{{ $featured->title }}</h2>
                        <p class="mt-4 max-w-lg text-sm sm:text-base leading-relaxed text-white/70">{{ $featured->excerpt }}</p>
                        <div class="mt-6 flex flex-wrap items-center gap-4 text-xs font-semibold text-white/60">
                            <span class="inline-flex items-center gap-2"><x-icon :name="$featured->category?->icon ?? 'sparkle'" class="size-4 text-sky-400"/>{{ $featured->category?->name }}</span>
                            <span class="inline-flex items-center gap-2"><x-icon name="clock" class="size-4 text-sky-400"/>{{ $featured->display_date }}</span>
                            <span class="inline-flex items-center gap-2"><x-icon name="eye" class="size-4 text-sky-400"/>{{ number_format($featured->views) }} kali dibaca</span>
                        </div>
                        <a href="{{ route('post.show', $featured) }}" class="group mt-8 inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-3.5 text-sm font-bold text-navy-900 transition-all duration-300 hover:bg-sky-50 hover:-translate-y-0.5">
                            Lanjut Baca
                            <x-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-1"/>
                        </a>
                    </div>

                    <div class="relative hidden lg:block">
                        @if ($featured->image)
                            <img src="{{ asset('storage/'.$featured->image) }}" alt="{{ $featured->title }}" class="rounded-2xl shadow-lift">
                        @else
                            <div class="grid place-items-center rounded-2xl bg-white/10 backdrop-blur p-10 aspect-square">
                                <x-icon :name="$featured->category?->icon ?? 'sparkle'" class="size-52 text-white/30"/>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        {{-- HALTE-HALTE PERJALANAN --}}
        @php
            $stops = [
                ['id' => 'pengumuman', 'slug' => 'pengumuman', 'num' => '01', 'title' => 'Papan Info', 'desc' => 'Informasi penting yang perlu kamu tahu lebih dulu.'],
                ['id' => 'prestasi', 'slug' => 'prestasi', 'num' => '02', 'title' => 'Prestasi', 'desc' => 'Kabar membanggakan dari warga sekolah kita.'],
                ['id' => 'kegiatan', 'slug' => 'kegiatan', 'num' => '03', 'title' => 'Kegiatan', 'desc' => 'Momen seru dari agenda sekolah sepanjang tahun.'],
                ['id' => 'karya', 'slug' => 'karya', 'num' => '04', 'title' => 'Karya & Kreativitas', 'desc' => 'Karya, tulisan, dan ide kreatif siswa.'],
            ];
        @endphp

        @foreach ($stops as $index => $stop)
            @php
                $category = $categories->firstWhere('slug', $stop['slug']);
                $postsInStop = $posts->where('category.slug', $stop['slug'])->take(4);
                $isReversed = $index % 2 === 1;
            @endphp
            @if ($category && $postsInStop->isNotEmpty())
                <section id="{{ $stop['id'] }}" class="scroll-mt-28 border-t border-navy-900/5 bg-white">
                    <div class="mx-auto max-w-6xl px-4 sm:px-6 py-16 sm:py-20">
                        <div class="reveal flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
                            <div>
                                <div class="flex items-center gap-4">
                                    <span class="grid place-items-center size-11 rounded-2xl bg-gradient-to-br from-navy-800 to-royal-600 text-white shadow-glow">
                                        <x-icon :name="$category->icon" class="size-5"/>
                                    </span>
                                    <div>
                                        <p class="font-display text-3xl font-extrabold text-royal-500/30">{{ $stop['num'] }}</p>
                                    </div>
                                </div>
                                <h2 class="mt-4 font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-navy-900">{{ $stop['title'] }}</h2>
                                <p class="mt-2 max-w-lg text-sm sm:text-base text-navy-900/55">{{ $category->description }}</p>
                            </div>
                            <a href="{{ route('category', $category) }}" class="group inline-flex shrink-0 items-center gap-2 rounded-2xl bg-ice-100 px-5 py-3 text-sm font-bold text-navy-900 transition-colors hover:bg-royal-600 hover:text-white">
                                Lihat Semua
                                <x-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-1"/>
                            </a>
                        </div>

                        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach ($postsInStop as $post)
                                <div class="reveal" style="transition-delay: {{ $loop->index * 0.07 }}s">
                                    <x-post-card :post="$post"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endforeach

        {{-- SEMUA KONTEN — peta lengkap perjalanan --}}
        <section id="semua" class="scroll-mt-28 mx-auto max-w-6xl px-4 sm:px-6 py-16 sm:py-20">
            <div class="reveal max-w-2xl">
                <span class="inline-flex items-center gap-2 rounded-full bg-ice-100 px-3.5 py-1.5 text-xs font-bold text-royal-600 ring-1 ring-royal-500/20">
                    <x-icon name="map-pin" class="size-3.5"/>
                    Peta Lengkap
                </span>
                <h2 class="mt-4 font-display text-2xl sm:text-3xl font-extrabold tracking-tight text-navy-900">Semua Cerita dalam Satu Peta</h2>
                <p class="mt-2 text-sm sm:text-base text-navy-900/55">Jelajahi semua halte. Saring berdasarkan kategori untuk menemukan cerita yang sedang kamu cari.</p>
            </div>

            <div class="reveal mt-8 flex flex-wrap gap-2" style="transition-delay:.05s">
                <a href="{{ route('home', ['category' => '', 'q' => request('q')]) }}"
                   class="rounded-full px-4 py-2 text-xs font-bold transition-colors {{ ! $activeCategory ? 'bg-navy-900 text-white' : 'bg-ice-100 text-navy-800 hover:bg-ice-200' }}">
                    Semua
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('home', ['category' => $category->slug, 'q' => request('q')]) }}"
                       class="inline-flex items-center gap-1.5 rounded-full px-4 py-2 text-xs font-bold transition-colors {{ $activeCategory === $category->slug ? 'bg-navy-900 text-white' : 'bg-ice-100 text-navy-800 hover:bg-ice-200' }}">
                        <x-icon :name="$category->icon" class="size-3.5"/>
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($posts as $post)
                    <div class="reveal" style="transition-delay: {{ min($loop->index, 5) * 0.06 }}s">
                        <x-post-card :post="$post"/>
                    </div>
                @empty
                    <div class="col-span-full grid place-items-center rounded-3xl bg-white ring-1 ring-navy-900/5 py-20 text-center">
                        <x-icon name="search" class="size-12 text-royal-500/40"/>
                        <p class="mt-4 font-display font-bold text-lg text-navy-900">Belum ada cerita ditemukan</p>
                        <p class="mt-1 text-sm text-navy-900/55 max-w-sm">Coba kata kunci lain atau pilih kategori yang berbeda.</p>
                        <a href="{{ route('home') }}" class="mt-5 rounded-xl bg-navy-900 px-5 py-2.5 text-xs font-bold text-white hover:bg-navy-800">Reset Pencarian</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        </section>

        {{-- PENUTUP --}}
        <section class="relative overflow-hidden bg-navy-900">
            <div class="absolute inset-0 bg-grid-blue opacity-20"></div>
            <div class="absolute -bottom-24 -left-24 size-96 rounded-full bg-royal-500/20 blur-3xl"></div>
            <div class="absolute -top-24 -right-24 size-96 rounded-full bg-sky-400/15 blur-3xl"></div>
            <div class="relative mx-auto max-w-4xl px-4 sm:px-6 py-20 text-center text-white">
                <x-icon name="map-pin" class="mx-auto size-10 text-sky-400"/>
                <h2 class="mt-6 font-display text-3xl sm:text-4xl font-extrabold tracking-tight text-balance">Perjalanan belum berakhir — masih banyak cerita menanti.</h2>
                <p class="mt-4 mx-auto max-w-xl text-sm sm:text-base text-white/65">Terima kasih sudah berhenti di papan ini. Kembalilah lagi untuk membaca kisah terbaru dari sekolah kita.</p>
                <a href="#semua" class="mt-8 inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-3.5 text-sm font-bold text-navy-900 hover:bg-sky-50 transition-colors">
                    Jelajahi Lagi
                    <x-icon name="arrow-right" class="size-4"/>
                </a>
            </div>
        </section>
    </div>
@endsection
