@extends('layouts.app')

@section('title', 'Majalah Dinding Sekolah')
@section('meta_description', 'Pengumuman, berita, karya siswa, agenda, dan prestasi sekolah.')

@section('content')
    {{-- HERO --}}
    <section class="border-b-2 border-ink">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 pt-28 sm:pt-32 pb-14">
            <div class="grid gap-10 lg:grid-cols-12 lg:gap-12">
                <div class="lg:col-span-7">
                    <span class="kicker" data-hero="kicker">Majalah Dinding Digital</span>

                    <h1 class="mt-4 font-display text-[clamp(2.2rem,5.5vw,4rem)] font-bold leading-[1.08] tracking-tight text-ink text-balance" data-hero="title">
                        Informasi sekolah & <span class="italic text-blue">karya siswanya</span> dalam satu papan.
                    </h1>

                    <p class="mt-5 max-w-xl text-base leading-relaxed text-ink-2 sm:text-lg" data-hero="desc">
                        Pengumuman terbaru, berita kegiatan, tulisan siswa, agenda, dan prestasi — semua ada di sini.
                    </p>

                    <form method="GET" action="{{ route('cari.index') }}" class="mt-7 max-w-xl" data-hero="search">
                        <div class="relative">
                            <input
                                type="search"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Cari pengumuman, berita, karya…"
                                class="field border-2 !py-4 pr-28"
                                aria-label="Cari konten"
                            >
                            <button type="submit" class="btn-ink absolute right-2 top-1/2 !px-4 -translate-y-1/2">
                                Cari
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 flex flex-wrap items-center gap-x-8 gap-y-3 text-sm text-ink-2" data-hero="stats">
                        <span><strong class="font-bold text-ink" data-count="{{ $totalBerita }}">0</strong> berita</span>
                        <span><strong class="font-bold text-ink" data-count="{{ $totalArtikel }}">0</strong> karya siswa</span>
                        <span><strong class="font-bold text-ink" data-count="{{ $totalPrestasi }}">0</strong> prestasi</span>
                        <span><strong class="font-bold text-ink" data-count="{{ $totalViews }}">0</strong> kali dibaca</span>
                    </div>
                </div>

                @if ($featured)
                    <div class="lg:col-span-5" data-hero="featured">
                        <article class="group relative card h-full flex flex-col overflow-hidden">
                            <a href="{{ route('berita.show', $featured) }}" class="absolute inset-0 z-10" aria-label="Baca {{ $featured->title }}"></a>

                            <div class="relative aspect-[16/11] overflow-hidden bg-paper-deep">
                                @if ($featured->image)
                                    <div class="img-skel relative h-full w-full">
                                        <div class="skeleton-image absolute inset-0"></div>
                                        <img data-src="{{ asset('storage/'.$featured->image) }}" alt="{{ $featured->title }}" loading="lazy" class="h-full w-full object-cover opacity-0 transition-opacity duration-500 group-hover:scale-105">
                                    </div>
                                @endif
                                <span class="absolute left-3 top-3 z-20 tag-ink">
                                    Berita Utama
                                </span>
                            </div>

                            <div class="flex flex-1 flex-col p-5">
                                <div class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-ink-3">
                                    <span class="text-accent">{{ $featured->category?->name }}</span>
                                    <span>·</span>
                                    <span>{{ $featured->display_date }}</span>
                                </div>
                                <h2 class="mt-2.5 font-display text-xl font-bold leading-snug tracking-tight text-ink text-balance">{{ $featured->title }}</h2>
                                <p class="mt-2 text-sm leading-relaxed text-ink-2 line-clamp-3">{{ $featured->excerpt }}</p>
                                <div class="mt-auto pt-4 text-xs font-semibold text-ink-3">
                                    {{ $featured->author }}
                                </div>
                            </div>
                        </article>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- PENGUMUMAN + AGENDA --}}
    <section class="mx-auto max-w-6xl px-4 sm:px-6 py-14 sm:py-16" data-section>
        <div class="grid gap-10 lg:grid-cols-2 lg:gap-12">
            <div>
                <div class="flex items-center justify-between gap-4">
                    <x-section-head title="Pengumuman" />
                    <a href="{{ route('pengumuman.index') }}" class="btn-ghost shrink-0">
                        Semua <x-icon name="arrow-right" class="size-4"/>
                    </a>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse ($pengumuman as $peng)
                        <div class="group flex gap-4 card card-hover p-4">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    @if ($peng->is_pinned)
                                        <span class="tag-ink">PIN</span>
                                    @endif
                                    <span class="{{ $peng->priority === 'mendesak' ? 'tag-red' : ($peng->priority === 'penting' ? 'tag-amber' : 'tag-gray') }}">
                                        {{ $peng->priority_label }}
                                    </span>
                                </div>
                                <h3 class="mt-1.5 font-display text-base font-bold leading-snug text-ink group-hover:text-accent transition-colors">{{ $peng->title }}</h3>
                                <p class="mt-1 text-sm leading-relaxed text-ink-2 line-clamp-2">{{ $peng->content }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="card p-5 text-sm text-ink-3">Belum ada pengumuman.</div>
                    @endforelse
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between gap-4">
                    <x-section-head title="Agenda Mendatang" />
                    <a href="{{ route('agenda.index') }}" class="btn-ghost shrink-0">
                        Semua <x-icon name="arrow-right" class="size-4"/>
                    </a>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse ($agenda as $event)
                        <x-event-card :event="$event" />
                    @empty
                        <div class="card p-5 text-sm text-ink-3">Belum ada agenda mendatang.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- BERITA SEKOLAH --}}
    @if ($berita->isNotEmpty())
        <section class="border-y-2 border-ink bg-cream" data-section>
            <div class="mx-auto max-w-6xl px-4 sm:px-6 py-14 sm:py-16">
                <x-section-head
                    title="Berita Sekolah"
                    desc="Kegiatan dan kabar terbaru dari sekolah."
                    :link="route('berita.index')"
                    linkLabel="Semua Berita"
                />

                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($berita as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- KARYA SISWA --}}
    @if ($artikel->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 sm:px-6 py-14 sm:py-16" data-section>
            <x-section-head
                title="Karya & Artikel Siswa"
                desc="Tulisan hasil karya teman-teman: cerpen, puisi, opini, dan sebagainya."
                :link="route('artikel.index')"
                linkLabel="Semua Artikel"
            />

            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($artikel as $article)
                    <x-article-card :article="$article" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- PRESTASI --}}
    @if ($prestasi->isNotEmpty())
        <section class="border-y-2 border-ink bg-ink text-paper" data-section>
            <div class="mx-auto max-w-6xl px-4 sm:px-6 py-14 sm:py-16">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="font-display text-2xl font-bold tracking-tight text-cream sm:text-3xl">Prestasi</h2>
                        <p class="mt-1.5 max-w-lg text-sm leading-relaxed text-cream/60">Juara lomba dan penghargaan yang diraih siswa.</p>
                    </div>
                    <a href="{{ route('prestasi.index') }}" class="btn-acid shrink-0">
                        Semua Prestasi <x-icon name="arrow-right" class="size-4"/>
                    </a>
                </div>

                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($prestasi as $achievement)
                        <x-achievement-card :achievement="$achievement" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- KATEGORI --}}
    <section class="mx-auto max-w-6xl px-4 sm:px-6 py-14 sm:py-16" data-section>
        <div class="max-w-2xl">
            <h2 class="font-display text-2xl font-bold tracking-tight text-ink sm:text-3xl">Telusuri Kategori</h2>
        </div>

        <div class="mt-6 flex flex-wrap gap-2">
            @foreach ($categories as $category)
                <a href="{{ route('category', $category) }}" class="chip !px-4 !py-2">
                    {{ $category->name }}
                    <span class="rounded-brutal bg-ink/10 px-1.5 text-[10px] text-ink-2">{{ $category->published_posts_count + $category->published_articles_count }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- CTA --}}
    <section class="border-t-2 border-ink bg-blue text-cream" data-section>
        <div class="mx-auto max-w-4xl px-4 sm:px-6 py-14 text-center">
            <h2 class="font-display text-2xl font-bold tracking-tight text-cream sm:text-3xl">
                Punya tulisan atau karya untuk dipajang?
            </h2>
            <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-cream/75">
                Sampaikan ke guru pembina atau pengurus mading. Karya yang disetujui akan tampil di papan digital sekolah.
            </p>
            <a href="{{ route('tentang') }}" class="btn-ink mx-auto mt-7">
                Tentang Mading <x-icon name="arrow-right" class="size-4"/>
            </a>
        </div>
    </section>
@endsection
