@extends('layouts.app')

@section('title', $announcement->title . ' — Pengumuman')
@section('meta_description', Str::limit(strip_tags($announcement->content), 150))

@section('content')
    <article class="mx-auto max-w-3xl px-4 sm:px-6 pt-28 sm:pt-32">
        <a href="{{ route('pengumuman.index') }}" class="btn-ghost text-xs">
            <x-icon name="arrow-left" class="size-4"/>
            Kembali ke Pengumuman
        </a>

        <header class="mt-6">
            <div class="flex flex-wrap items-center gap-2.5">
                <span class="{{ $announcement->priority === 'mendesak' ? 'tag-red' : ($announcement->priority === 'penting' ? 'tag-amber' : 'tag-gray') }}">{{ $announcement->priority_label }}</span>
                @if ($announcement->is_pinned)
                    <span class="tag-ink">Disematkan</span>
                @endif
            </div>

            <h1 class="mt-5 font-display text-3xl font-bold leading-tight tracking-tight text-ink text-balance sm:text-4xl sm:leading-tight">{{ $announcement->title }}</h1>

            <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-2 border-y-2 border-ink/10 py-4 text-sm font-semibold text-ink-2">
                @if ($announcement->start_date)
                    <span class="inline-flex items-center gap-1.5">
                        <x-icon name="calendar" class="size-4 text-ink-3"/>
                        {{ $announcement->start_date->translatedFormat('d M Y') }}@if ($announcement->end_date) — {{ $announcement->end_date->translatedFormat('d M Y') }}@endif
                    </span>
                @endif
                <span class="inline-flex items-center gap-1.5">
                    <x-icon name="clock" class="size-4 text-ink-3"/>
                    {{ $announcement->created_at->translatedFormat('d M Y') }}
                </span>
            </div>
        </header>

        <div class="prose-wrap mt-10">
            {!! nl2br(e($announcement->content)) !!}
        </div>
    </article>

    <div class="mx-auto max-w-3xl px-4 sm:px-6 mt-12">
        <div class="post-nav">
            @if ($prev)
                <a href="{{ route('pengumuman.show', $prev) }}">
                    <span class="post-nav-icon"><x-icon name="arrow-left" class="size-4"/></span>
                    <span class="flex-1 min-w-0">
                        <span class="post-nav-label">Pengumuman Sebelumnya</span>
                        <span class="post-nav-title">{{ $prev->title }}</span>
                    </span>
                </a>
            @else
                <a href="#">
                    <span class="post-nav-empty">Tidak ada pengumuman sebelumnya</span>
                </a>
            @endif

            @if ($next)
                <a href="{{ route('pengumuman.show', $next) }}" class="sm:text-right">
                    <span class="post-nav-icon sm:order-last"><x-icon name="arrow-right" class="size-4"/></span>
                    <span class="flex-1 min-w-0 sm:order-first">
                        <span class="post-nav-label">Pengumuman Selanjutnya</span>
                        <span class="post-nav-title">{{ $next->title }}</span>
                    </span>
                </a>
            @else
                <a href="#" class="sm:text-right">
                    <span class="post-nav-empty">Tidak ada pengumuman selanjutnya</span>
                </a>
            @endif
        </div>
    </div>
@endsection
