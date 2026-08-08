@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    {{-- Statistik --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $stats = [
                ['label' => 'Total Cerita', 'value' => $totalPosts, 'icon' => 'folder', 'tone' => 'from-navy-800 to-royal-600'],
                ['label' => 'Cerita Tampil', 'value' => $publishedPosts, 'icon' => 'check', 'tone' => 'from-royal-500 to-sky-500'],
                ['label' => 'Kategori', 'value' => $totalCategories, 'icon' => 'grid', 'tone' => 'from-sky-500 to-sky-400'],
                ['label' => 'Total Pembaca', 'value' => number_format($totalViews), 'icon' => 'eye', 'tone' => 'from-navy-700 to-navy-600'],
            ];
        @endphp
        @foreach ($stats as $stat)
            <div class="reveal rounded-3xl bg-white p-5 shadow-soft ring-1 ring-navy-900/5" style="transition-delay: {{ $loop->index * 0.06 }}s">
                <div class="flex items-center justify-between">
                    <span class="grid place-items-center size-11 rounded-2xl bg-gradient-to-br {{ $stat['tone'] }} text-white shadow-glow">
                        <x-icon :name="$stat['icon']" class="size-5"/>
                    </span>
                    <x-icon name="chart" class="size-5 text-navy-900/15"/>
                </div>
                <p class="mt-4 font-display text-2xl font-extrabold text-navy-900">{{ $stat['value'] }}</p>
                <p class="mt-1 text-xs font-semibold text-navy-900/50">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        {{-- Konten terbaru --}}
        <div class="reveal lg:col-span-2 rounded-3xl bg-white shadow-soft ring-1 ring-navy-900/5 p-6" style="transition-delay:.1s">
            <div class="flex items-center justify-between">
                <h2 class="font-display font-extrabold text-lg text-navy-900">Konten Terbaru</h2>
                <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-royal-600 hover:text-navy-900 transition-colors">
                    Kelola Semua
                    <x-icon name="arrow-right" class="size-3.5"/>
                </a>
            </div>

            <div class="mt-5 divide-y divide-navy-900/5">
                @forelse ($latestPosts as $post)
                    <div class="flex items-center gap-4 py-3.5">
                        <span class="grid place-items-center size-10 shrink-0 rounded-xl bg-ice-100 text-royal-600">
                            <x-icon :name="$post->category?->icon ?? 'sparkle'" class="size-5"/>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-navy-900">{{ $post->title }}</p>
                            <p class="mt-0.5 text-xs text-navy-900/50">
                                {{ $post->category?->name }} · {{ $post->display_date }}
                            </p>
                        </div>
                        <div class="flex shrink-0 items-center gap-2">
                            @if ($post->is_published)
                                <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-600 ring-1 ring-emerald-200">Tampil</span>
                            @else
                                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-bold text-amber-600 ring-1 ring-amber-200">Draft</span>
                            @endif
                            <a href="{{ route('admin.posts.edit', $post) }}" class="grid place-items-center size-8 rounded-lg bg-ice-100 text-navy-800 hover:bg-royal-600 hover:text-white transition-colors" title="Edit">
                                <x-icon name="edit" class="size-3.5"/>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="py-10 text-center text-sm text-navy-900/50">Belum ada konten. Tulis cerita pertamamu!</p>
                @endforelse
            </div>
        </div>

        {{-- Sebaran per kategori --}}
        <div class="reveal rounded-3xl bg-white shadow-soft ring-1 ring-navy-900/5 p-6" style="transition-delay:.15s">
            <h2 class="font-display font-extrabold text-lg text-navy-900">Sebaran Kategori</h2>

            <div class="mt-5 space-y-4">
                @forelse ($postsByCategory as $category)
                    @php
                        $max = max($postsByCategory->max('posts_count'), 1);
                        $pct = round(($category->posts_count / $max) * 100);
                    @endphp
                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="inline-flex items-center gap-2 font-bold text-navy-900">
                                <x-icon :name="$category->icon" class="size-4 text-royal-600"/>
                                {{ $category->name }}
                            </span>
                            <span class="font-bold text-navy-900/50">{{ $category->posts_count }}</span>
                        </div>
                        <div class="mt-2 h-2.5 overflow-hidden rounded-full bg-ice-100">
                            <div class="h-full rounded-full bg-gradient-to-r from-navy-800 to-royal-600 transition-all duration-700" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-navy-900/50">Belum ada kategori.</p>
                @endforelse
            </div>

            <a href="{{ route('home') }}" target="_blank" class="group mt-6 flex items-center justify-center gap-2 rounded-2xl bg-navy-900 px-5 py-3.5 text-sm font-bold text-white hover:bg-navy-800 transition-colors">
                Lihat Papan Publik
                <x-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-1"/>
            </a>
        </div>
    </div>
@endsection
