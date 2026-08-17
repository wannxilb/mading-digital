@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    {{-- Statistik --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @php
            $stats = [
                ['label' => 'Total Berita', 'value' => $totalBerita, 'icon' => 'book', 'accent' => 'bg-acid'],
                ['label' => 'Total Artikel', 'value' => $totalArtikel, 'icon' => 'pen', 'accent' => 'bg-blue'],
                ['label' => 'Menunggu Review', 'value' => $pendingArtikel, 'icon' => 'clock', 'accent' => 'bg-accent'],
                ['label' => 'Pengumuman Aktif', 'value' => $activePengumuman, 'icon' => 'megaphone', 'accent' => 'bg-acid'],
                ['label' => 'Agenda Mendatang', 'value' => $agendaMendatang, 'icon' => 'calendar', 'accent' => 'bg-green'],
                ['label' => 'Prestasi', 'value' => $totalPrestasi, 'icon' => 'award', 'accent' => 'bg-amber'],
                ['label' => 'Total Pengguna', 'value' => $totalUsers, 'icon' => 'users', 'accent' => 'bg-blue'],
                ['label' => 'Total Pembaca', 'value' => number_format($totalViews), 'icon' => 'eye', 'accent' => 'bg-ink'],
            ];
        @endphp
        @foreach ($stats as $stat)
            <div class="reveal card card-hover border-2 p-5" style="transition-delay: {{ $loop->index * 0.04 }}s">
                <div class="flex items-center justify-between">
                    <span class="grid size-11 place-items-center rounded-brutal border-2 border-ink shadow-brutal-sm {{ $stat['accent'] }} text-ink">
                        <x-icon :name="$stat['icon']" class="size-5"/>
                    </span>
                    <x-icon name="chart" class="size-5 text-ink-3/60"/>
                </div>
                <p class="mt-4 font-display text-2xl font-bold text-ink">{{ $stat['value'] }}</p>
                <p class="mt-1 text-xs font-bold uppercase tracking-wider text-ink-3">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-3">
        {{-- Konten terbaru --}}
        <div class="reveal card border-2 p-6 lg:col-span-2" style="transition-delay:.1s">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-lg font-bold text-ink">Berita Terbaru</h2>
                <a href="{{ route('admin.berita.index') }}" class="btn-ghost text-xs">Kelola Semua</a>
            </div>

            <div class="mt-4 divide-y-2 divide-ink/10">
                @forelse ($latestPosts as $post)
                    <div class="flex items-center gap-4 py-3.5">
                        <span class="grid size-10 shrink-0 place-items-center rounded-brutal border-2 border-ink bg-acid">
                            <x-icon :name="$post->category?->icon ?? 'sparkle'" class="size-4.5"/>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-ink">{{ $post->title }}</p>
                            <p class="mt-0.5 text-xs font-semibold text-ink-3">{{ $post->category?->name }} · {{ $post->display_date }}</p>
                        </div>
                        <div class="flex shrink-0 items-center gap-2">
                            @if ($post->is_published)
                                <span class="tag-green">Tampil</span>
                            @else
                                <span class="tag-amber">Draft</span>
                            @endif
                            <a href="{{ route('admin.berita.edit', $post) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Edit">
                                <x-icon name="edit" class="size-3.5"/>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="py-10 text-center text-sm text-ink-2">Belum ada berita. Tulis berita pertamamu!</p>
                @endforelse
            </div>

            <h2 class="mt-8 font-display text-lg font-bold text-ink">Artikel Terbaru</h2>
            <div class="mt-4 divide-y-2 divide-ink/10">
                @forelse ($latestArticles as $article)
                    <div class="flex items-center gap-4 py-3.5">
                        <span class="grid size-10 shrink-0 place-items-center rounded-brutal border-2 border-ink bg-blue text-cream">
                            <x-icon :name="$article->category?->icon ?? 'pen'" class="size-4.5"/>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-ink">{{ $article->title }}</p>
                            <p class="mt-0.5 text-xs font-semibold text-ink-3">{{ $article->author }} · {{ $article->status_label }}</p>
                        </div>
                        <div class="flex shrink-0 items-center gap-2">
                            <span class="tag-{{ $article->status === 'published' ? 'green' : ($article->status === 'review' ? 'amber' : 'gray') }}">{{ $article->status_label }}</span>
                            <a href="{{ route('admin.artikel.edit', $article) }}" class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-cream text-ink transition-colors hover:bg-acid" title="Edit">
                                <x-icon name="edit" class="size-3.5"/>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="py-10 text-center text-sm text-ink-2">Belum ada artikel.</p>
                @endforelse
            </div>
        </div>

        {{-- Sisi kanan: agenda + kategori --}}
        <div class="space-y-6">
            <div class="reveal card border-2 p-6" style="transition-delay:.15s">
                <div class="flex items-center justify-between">
                    <h2 class="font-display text-lg font-bold text-ink">Agenda Mendatang</h2>
                    <a href="{{ route('admin.agenda.index') }}" class="btn-ghost text-xs">Semua</a>
                </div>
                <div class="mt-4 space-y-3">
                    @forelse ($upcomingEvents as $event)
                        <div class="flex items-stretch overflow-hidden rounded-brutal border-2 border-ink">
                            <div class="flex flex-col items-center justify-center bg-acid px-3 py-2 text-center text-ink">
                                <span class="font-display text-lg font-bold leading-none">{{ $event->event_date->format('d') }}</span>
                                <span class="text-[10px] font-bold uppercase tracking-widest">{{ $event->event_date->translatedFormat('M') }}</span>
                            </div>
                            <div class="flex min-w-0 flex-1 items-center px-3 py-2">
                                <p class="truncate text-sm font-bold text-ink">{{ $event->title }}</p>
                            </div>
                            <a href="{{ route('admin.agenda.edit', $event) }}" class="grid place-items-center border-l-2 border-ink px-3 text-ink transition-colors hover:bg-acid" title="Edit">
                                <x-icon name="edit" class="size-3.5"/>
                            </a>
                        </div>
                    @empty
                        <p class="py-6 text-center text-sm text-ink-2">Belum ada agenda mendatang.</p>
                    @endforelse
                </div>
            </div>

            <div class="reveal card border-2 p-6" style="transition-delay:.2s">
                <h2 class="font-display text-lg font-bold text-ink">Sebaran Berita per Kategori</h2>
                <div class="mt-4 space-y-4">
                    @forelse ($postsByCategory as $category)
                        @php
                            $max = max($postsByCategory->first()?->posts_count ?? 1, 1);
                            $pct = round(($category->posts_count / $max) * 100);
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="inline-flex items-center gap-2 font-bold text-ink">
                                    <x-icon :name="$category->icon" class="size-4 text-accent"/>
                                    {{ $category->name }}
                                </span>
                                <span class="font-bold text-ink-2">{{ $category->posts_count }}</span>
                            </div>
                            <div class="mt-2 h-3 rounded-brutal border-2 border-ink bg-paper">
                                <div class="h-full rounded-brutal bg-ink transition-all duration-700" style="width: {{ max($pct, 4) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="py-6 text-center text-sm text-ink-2">Belum ada kategori.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
