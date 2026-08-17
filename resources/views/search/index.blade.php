@extends('layouts.app')

@section('title', 'Cari Konten')
@section('meta_description', 'Cari berita, artikel, pengumuman, agenda, dan prestasi.')

@section('content')
    <section class="border-b-2 border-ink">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 pt-28 sm:pt-32 pb-12 text-center">
            <h1 class="font-display text-4xl font-bold tracking-tight text-ink sm:text-5xl">Cari di Papan</h1>

            <form method="GET" action="{{ route('cari.index') }}" class="mx-auto mt-8 max-w-xl">
                <div class="relative">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Ketik judul, isi konten, atau kategori…" autofocus class="field border-2 !py-4 pr-28" aria-label="Kata kunci pencarian">
                    <button type="submit" class="btn-ink absolute right-2 top-1/2 -translate-y-1/2">Cari</button>
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 py-12 sm:py-16">
        @if ($q === '')
            <div class="card grid place-items-center py-20 text-center">
                <x-icon name="search" class="size-12 text-ink-3"/>
                <p class="mt-4 font-display text-lg font-bold text-ink">Ketik kata kunci untuk mulai mencari</p>
                <p class="mt-1 max-w-sm text-sm text-ink-2">Contoh: "lomba", "ujian", "ekstrakurikuler".</p>
            </div>
        @elseif ($total === 0)
            <div class="card grid place-items-center py-20 text-center">
                <x-icon name="search" class="size-12 text-ink-3"/>
                <p class="mt-4 font-display text-lg font-bold text-ink">Tidak ditemukan untuk "{{ $q }}"</p>
                <p class="mt-1 max-w-sm text-sm text-ink-2">Coba kata kunci lain atau ejaan yang berbeda.</p>
            </div>
        @else
            <div class="mb-6 flex items-center justify-between">
                <p class="text-sm font-semibold text-ink-2">
                    Hasil pencarian untuk <strong class="text-ink">"{{ $q }}"</strong>
                </p>
                <span class="tag-blue">{{ $total }} hasil</span>
            </div>

            @foreach ([
                ['key' => 'berita', 'label' => 'Berita', 'icon' => 'book', 'color' => 'text-accent', 'route' => 'berita.show'],
                ['key' => 'artikel', 'label' => 'Artikel', 'icon' => 'pen', 'color' => 'text-blue', 'route' => 'artikel.show'],
            ] as $group)
                @if ($results[$group['key']]->isNotEmpty())
                    <div class="mb-10">
                        <div class="flex items-center gap-2.5 border-b-2 border-ink pb-2.5">
                            <x-icon :name="$group['icon']" class="size-4 {{ $group['color'] }}"/>
                            <h2 class="font-display text-lg font-bold text-ink">{{ $group['label'] }}</h2>
                            <span class="ml-auto text-xs font-bold text-ink-3">{{ $results[$group['key']]->count() }}</span>
                        </div>
                        <div class="mt-4 space-y-3">
                            @foreach ($results[$group['key']] as $item)
                                <a href="{{ route($group['route'], $item) }}" class="group flex items-start gap-4 card card-hover p-4">
                                    <div class="relative hidden h-20 w-28 shrink-0 overflow-hidden rounded-brutal border-2 border-ink bg-paper-deep sm:block">
                                        @if ($item->image)
                                            <img src="{{ asset('storage/'.$item->image) }}" alt="" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[11px] font-bold uppercase tracking-wider text-ink-3">{{ $item->category?->name }} · {{ $item->display_date }}</p>
                                        <h3 class="mt-1 font-display text-base font-bold leading-snug text-ink group-hover:text-accent transition-colors">{{ $item->title }}</h3>
                                        <p class="mt-1 text-sm text-ink-2 line-clamp-2">{{ $item->excerpt ?: Str::limit(strip_tags($item->body), 130) }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            @if ($results['pengumuman']->isNotEmpty())
                <div class="mb-10">
                    <div class="flex items-center gap-2.5 border-b-2 border-ink pb-2.5">
                        <x-icon name="megaphone" class="size-4 text-accent"/>
                        <h2 class="font-display text-lg font-bold text-ink">Pengumuman</h2>
                        <span class="ml-auto text-xs font-bold text-ink-3">{{ $results['pengumuman']->count() }}</span>
                    </div>
                    <div class="mt-4 space-y-3">
                        @foreach ($results['pengumuman'] as $peng)
                            <a href="{{ route('pengumuman.index') }}" class="group flex items-start gap-4 card card-hover p-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-[11px] font-bold uppercase tracking-wider text-ink-3">{{ $peng->priority_label }}</span>
                                        @if ($peng->start_date)
                                            <span class="text-[11px] font-semibold text-ink-3">{{ $peng->start_date->translatedFormat('d M Y') }}</span>
                                        @endif
                                    </div>
                                    <h3 class="mt-1 font-display text-base font-bold leading-snug text-ink group-hover:text-accent transition-colors">{{ $peng->title }}</h3>
                                    <p class="mt-1 text-sm text-ink-2 line-clamp-2">{{ $peng->content }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($results['agenda']->isNotEmpty())
                <div class="mb-10">
                    <div class="flex items-center gap-2.5 border-b-2 border-ink pb-2.5">
                        <x-icon name="calendar" class="size-4 text-green"/>
                        <h2 class="font-display text-lg font-bold text-ink">Agenda</h2>
                        <span class="ml-auto text-xs font-bold text-ink-3">{{ $results['agenda']->count() }}</span>
                    </div>
                    <div class="mt-4 space-y-3">
                        @foreach ($results['agenda'] as $event)
                            <a href="{{ route('agenda.index') }}" class="group flex items-start gap-4 card card-hover p-4">
                                <div class="flex shrink-0 flex-col items-center justify-center rounded-brutal border-2 border-ink bg-acid px-3 py-1.5 text-ink">
                                    <span class="font-display text-xl font-bold leading-none">{{ $event->event_date->format('d') }}</span>
                                    <span class="text-[10px] font-bold uppercase tracking-widest">{{ $event->event_date->translatedFormat('M') }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-display text-base font-bold leading-snug text-ink group-hover:text-accent transition-colors">{{ $event->title }}</h3>
                                    @if ($event->location)
                                        <p class="mt-1 inline-flex items-center gap-1 text-sm font-semibold text-ink-2">
                                            <x-icon name="location" class="size-3.5"/>
                                            {{ $event->location }}
                                        </p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($results['prestasi']->isNotEmpty())
                <div>
                    <div class="flex items-center gap-2.5 border-b-2 border-ink pb-2.5">
                        <x-icon name="trophy" class="size-4 text-amber"/>
                        <h2 class="font-display text-lg font-bold text-ink">Prestasi</h2>
                        <span class="ml-auto text-xs font-bold text-ink-3">{{ $results['prestasi']->count() }}</span>
                    </div>
                    <div class="mt-4 space-y-3">
                        @foreach ($results['prestasi'] as $achievement)
                            <a href="{{ route('prestasi.index') }}" class="group flex items-start gap-4 card card-hover p-4">
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-display text-base font-bold leading-snug text-ink group-hover:text-accent transition-colors">{{ $achievement->title }}</h3>
                                    <p class="mt-1 text-sm text-ink-2 line-clamp-1">
                                        {{ $achievement->student_name ? $achievement->student_name.' · ' : '' }}{{ $achievement->competition_name ?? '—' }}
                                    </p>
                                    <div class="mt-1.5 flex flex-wrap items-center gap-2">
                                        <span class="tag-blue">{{ $achievement->level_label }}</span>
                                        @if ($achievement->rank)
                                            <span class="tag-ink">{{ $achievement->rank }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </section>
@endsection
