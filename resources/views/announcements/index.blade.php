@extends('layouts.app')

@section('title', 'Pengumuman')
@section('meta_description', 'Informasi penting dari sekolah: jadwal, libur, lomba, dan kegiatan.')

@section('content')
    <section class="border-b-2 border-ink">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 pt-28 sm:pt-32 pb-10">
            <h1 class="font-display text-4xl font-bold tracking-tight text-ink sm:text-5xl">Pengumuman</h1>
            <p class="mt-3 max-w-xl text-sm leading-relaxed text-ink-2 sm:text-base">Informasi penting dari sekolah yang perlu diketahui.</p>

            <form method="GET" action="{{ route('pengumuman.index') }}" class="mt-6 max-w-md">
                <div class="relative">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari pengumuman…" class="field border-2 !py-3 pr-20" aria-label="Cari pengumuman">
                    <button type="submit" class="btn-ink absolute right-2 top-1/2 !px-3.5 !py-1.5 -translate-y-1/2 text-xs">Cari</button>
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 sm:px-6 py-12 sm:py-16">
        @if ($pinned->isNotEmpty())
            <div class="mb-8">
                <p class="kicker mb-4">Disematkan</p>
                <div class="space-y-3">
                    @foreach ($pinned as $peng)
                        <div class="group card card-hover p-5 border-ink bg-acid/10">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="tag-ink">PIN</span>
                                <span class="{{ $peng->priority === 'mendesak' ? 'tag-red' : ($peng->priority === 'penting' ? 'tag-amber' : 'tag-gray') }}">{{ $peng->priority_label }}</span>
                                @if ($peng->start_date)
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-ink-2">
                                        <x-icon name="calendar" class="size-3.5"/>
                                        {{ $peng->start_date->translatedFormat('d M Y') }}@if ($peng->end_date) — {{ $peng->end_date->translatedFormat('d M Y') }}@endif
                                    </span>
                                @endif
                            </div>
                            <h2 class="mt-2 font-display text-xl font-bold leading-snug text-ink">
                                <a href="{{ route('pengumuman.show', $peng) }}" class="hover:text-accent transition-colors">{{ $peng->title }}</a>
                            </h2>
                            <p class="mt-2 text-sm leading-relaxed text-ink-2">{!! nl2br(e($peng->content)) !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <p class="kicker mb-4">{{ $pinned->isNotEmpty() ? 'Pengumuman lainnya' : 'Semua Pengumuman' }}</p>

        <div class="space-y-3">
            @forelse ($others as $peng)
                <div class="group flex gap-4 card card-hover p-5">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="{{ $peng->priority === 'mendesak' ? 'tag-red' : ($peng->priority === 'penting' ? 'tag-amber' : 'tag-gray') }}">{{ $peng->priority_label }}</span>
                            @if ($peng->start_date)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-ink-3">
                                    <x-icon name="calendar" class="size-3.5"/>
                                    {{ $peng->start_date->translatedFormat('d M Y') }}@if ($peng->end_date) — {{ $peng->end_date->translatedFormat('d M Y') }}@endif
                                </span>
                            @endif
                        </div>
                        <h2 class="mt-1.5 font-display text-lg font-bold leading-snug text-ink group-hover:text-accent transition-colors">
                            <a href="{{ route('pengumuman.show', $peng) }}" class="hover:text-accent transition-colors">{{ $peng->title }}</a>
                        </h2>
                        <p class="mt-1.5 text-sm leading-relaxed text-ink-2">{!! nl2br(e($peng->content)) !!}</p>
                    </div>
                </div>
            @empty
                <div class="card grid place-items-center py-16 text-center">
                    <x-icon name="megaphone" class="size-12 text-ink-3"/>
                    <p class="mt-4 font-display text-lg font-bold text-ink">Belum ada pengumuman</p>
                    <p class="mt-1 text-sm text-ink-2">Pengumuman aktif akan tampil di sini.</p>
                </div>
            @endforelse
        </div>

        @if ($others->hasPages())
            {{ $others->links() }}
        @endif
    </section>
@endsection
