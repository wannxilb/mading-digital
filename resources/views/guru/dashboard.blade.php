@extends('layouts.guru')

@section('title', 'Dashboard Guru')
@section('heading', 'Dashboard')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $stats = [
                ['label' => 'Perlu Direview', 'value' => $pendingCount, 'icon' => 'clock', 'accent' => 'bg-amber'],
                ['label' => 'Total Artikel', 'value' => $totalArticles, 'icon' => 'pen', 'accent' => 'bg-blue'],
                ['label' => 'Published', 'value' => $publishedCount, 'icon' => 'check-circle', 'accent' => 'bg-green'],
                ['label' => 'Pengumuman', 'value' => $recentAnnouncements->count(), 'icon' => 'megaphone', 'accent' => 'bg-acid'],
            ];
        @endphp
        @foreach ($stats as $stat)
            <div class="card border-2 p-5">
                <div class="flex items-center justify-between">
                    <span class="grid size-11 place-items-center rounded-brutal border-2 border-ink shadow-brutal-sm {{ $stat['accent'] }} text-cream">
                        <x-icon :name="$stat['icon']" class="size-5"/>
                    </span>
                </div>
                <p class="mt-4 font-display text-2xl font-bold text-ink">{{ $stat['value'] }}</p>
                <p class="mt-1 text-xs font-bold uppercase tracking-wider text-ink-3">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        <div class="card border-2 p-6 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-lg font-bold text-ink">Artikel Perlu Review</h2>
                <a href="{{ route('guru.review.index') }}" class="btn-ghost text-xs">Lihat Semua</a>
            </div>

            <div class="mt-4 divide-y-2 divide-ink/10">
                @forelse ($pendingReview as $article)
                    <div class="flex items-center gap-4 py-3.5">
                        <span class="grid size-10 shrink-0 place-items-center rounded-brutal border-2 border-ink bg-amber text-cream">
                            <x-icon name="clock" class="size-4.5"/>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-ink">{{ $article->title }}</p>
                            <p class="mt-0.5 text-xs font-semibold text-ink-3">{{ $article->author }}@if ($article->class) ({{ $article->class }})@endif · {{ $article->category?->name }}</p>
                        </div>
                        <a href="{{ route('guru.review.show', $article) }}" class="btn-ink !px-3.5 !py-2 text-xs">
                            Review
                        </a>
                    </div>
                @empty
                    <div class="py-10 text-center">
                        <x-icon name="check-circle" class="mx-auto size-10 text-green"/>
                        <p class="mt-3 font-display font-bold text-ink">Semua artikel sudah direview</p>
                        <p class="mt-1 text-sm text-ink-2">Tidak ada artikel yang menunggu review saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="card border-2 p-6">
                <div class="flex items-center justify-between">
                    <h2 class="font-display text-lg font-bold text-ink">Pengumuman Terbaru</h2>
                    <a href="{{ route('guru.pengumuman.create') }}" class="btn-ghost text-xs">Buat Baru</a>
                </div>
                <div class="mt-4 space-y-3">
                    @forelse ($recentAnnouncements as $announcement)
                        <div class="rounded-brutal border-2 border-ink/10 p-3">
                            <p class="text-sm font-bold text-ink line-clamp-1">{{ $announcement->title }}</p>
                            <p class="mt-1 text-xs text-ink-3">{{ $announcement->created_at->diffForHumans() }} · {{ $announcement->priority_label }}</p>
                        </div>
                    @empty
                        <p class="py-6 text-center text-sm text-ink-2">Belum ada pengumuman.</p>
                    @endforelse
                </div>
            </div>

            <div class="card border-2 p-6">
                <h2 class="font-display text-lg font-bold text-ink">Aksi Cepat</h2>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('guru.review.index') }}" class="flex items-center gap-3 rounded-brutal border-2 border-ink px-4 py-3 text-sm font-bold text-ink transition-colors hover:bg-acid">
                        <x-icon name="check-circle" class="size-4.5"/>
                        Review Artikel
                    </a>
                    <a href="{{ route('guru.pengumuman.create') }}" class="flex items-center gap-3 rounded-brutal border-2 border-ink px-4 py-3 text-sm font-bold text-ink transition-colors hover:bg-acid">
                        <x-icon name="megaphone" class="size-4.5"/>
                        Buat Pengumuman
                    </a>
                    <a href="{{ route('guru.review.index', ['status' => 'review']) }}" class="flex items-center gap-3 rounded-brutal border-2 border-ink px-4 py-3 text-sm font-bold text-ink transition-colors hover:bg-acid">
                        <x-icon name="filter" class="size-4.5"/>
                        Filter: Menunggu Review
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
