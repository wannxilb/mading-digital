@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')
@section('heading', 'Dashboard')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $stats = [
                ['label' => 'Total Karya', 'value' => $totalArticles, 'icon' => 'pen', 'accent' => 'bg-blue'],
                ['label' => 'Published', 'value' => $publishedCount, 'icon' => 'check-circle', 'accent' => 'bg-green'],
                ['label' => 'Menunggu Review', 'value' => $reviewCount, 'icon' => 'clock', 'accent' => 'bg-amber'],
                ['label' => 'Total Dibaca', 'value' => number_format($totalViews), 'icon' => 'eye', 'accent' => 'bg-ink'],
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
                <h2 class="font-display text-lg font-bold text-ink">Karya Terbaru</h2>
                <a href="{{ route('siswa.karya.index') }}" class="btn-ghost text-xs">Lihat Semua</a>
            </div>

            <div class="mt-4 divide-y-2 divide-ink/10">
                @forelse ($myArticles as $article)
                    <div class="flex items-center gap-4 py-3.5">
                        <span class="grid size-10 shrink-0 place-items-center rounded-brutal border-2 border-ink bg-blue text-cream">
                            <x-icon :name="$article->category?->icon ?? 'pen'" class="size-4.5"/>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-ink">{{ $article->title }}</p>
                            <p class="mt-0.5 text-xs font-semibold text-ink-3">{{ $article->category?->name }} · {{ $article->display_date }}</p>
                        </div>
                        <div class="flex shrink-0 items-center gap-2">
                            @if ($article->status === 'published')
                                <span class="tag-green">Published</span>
                            @elseif ($article->status === 'review')
                                <span class="tag-amber">Review</span>
                            @elseif ($article->status === 'archived')
                                <span class="tag-gray">Arsip</span>
                            @else
                                <span class="tag-gray">Draft</span>
                            @endif
                            <a href="{{ route('siswa.karya.show', $article) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Lihat">
                                <x-icon name="eye" class="size-3.5"/>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center">
                        <x-icon name="pen" class="mx-auto size-10 text-ink-3"/>
                        <p class="mt-3 font-display font-bold text-ink">Belum ada karya</p>
                        <p class="mt-1 text-sm text-ink-2">Mulai tulis karya pertamamu!</p>
                        <a href="{{ route('siswa.karya.create') }}" class="btn-ink mt-5">Tulis Karya</a>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="card border-2 p-6">
                <h2 class="font-display text-lg font-bold text-ink">Status Karya</h2>
                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-ink">Published</span>
                        <span class="tag-green">{{ $publishedCount }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-ink">Menunggu Review</span>
                        <span class="tag-amber">{{ $reviewCount }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-ink">Draft</span>
                        <span class="tag-gray">{{ $draftCount }}</span>
                    </div>
                </div>
            </div>

            <div class="card border-2 p-6">
                <h2 class="font-display text-lg font-bold text-ink">Tips Menulis</h2>
                <ul class="mt-4 space-y-2 text-sm text-ink-2">
                    <li class="flex items-start gap-2">
                        <span class="mt-1 size-1.5 shrink-0 rounded-full bg-acid"></span>
                        Gunakan bahasa yang jelas dan mudah dipahami
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 size-1.5 shrink-0 rounded-full bg-acid"></span>
                        Sertakan judul yang menarik perhatian
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 size-1.5 shrink-0 rounded-full bg-acid"></span>
                        Panjang artikel idealnya 300-1000 kata
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="mt-1 size-1.5 shrink-0 rounded-full bg-acid"></span>
                        Gunakan format markdown untuk penulisan yang rapi
                    </li>
                </ul>
                <a href="{{ route('siswa.karya.create') }}" class="btn-ink mt-5 w-full">Tulis Karya Baru</a>
            </div>
        </div>
    </div>
@endsection
