@extends('layouts.admin')

@section('title', 'Menunggu Persetujuan')
@section('heading', 'Menunggu Persetujuan')

@section('content')
    @php
        $totalPending = $posts->count() + $articles->count() + $announcements->count();
        if ($type !== 'all') {
            $totalPending = match($type) {
                'berita' => $posts->total(),
                'artikel' => $articles->total(),
                'pengumuman' => $announcements->total(),
            };
        }
    @endphp

    <div class="mb-6 flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.persetujuan.index') }}" class="chip {{ $type === 'all' ? '!border-ink !bg-blue !text-cream' : '' }}">Semua ({{ $totalPending }})</a>
        <a href="{{ route('admin.persetujuan.index', ['type' => 'berita']) }}" class="chip {{ $type === 'berita' ? '!border-ink !bg-blue !text-cream' : '' }}">Berita</a>
        <a href="{{ route('admin.persetujuan.index', ['type' => 'artikel']) }}" class="chip {{ $type === 'artikel' ? '!border-ink !bg-blue !text-cream' : '' }}">Artikel</a>
        <a href="{{ route('admin.persetujuan.index', ['type' => 'pengumuman']) }}" class="chip {{ $type === 'pengumuman' ? '!border-ink !bg-blue !text-cream' : '' }}">Pengumuman</a>
    </div>

    {{-- Pending Berita --}}
    @if (($type === 'all' || $type === 'berita') && $posts->count())
        <div class="mb-8">
            <h2 class="font-display text-lg font-bold text-ink">Berita</h2>
            <div class="mt-4 space-y-4">
                @if ($type === 'all')
                    @foreach ($posts as $post)
                        @include('admin.approval._post', ['item' => $post])
                    @endforeach
                @else
                    @foreach ($posts as $post)
                        @include('admin.approval._post', ['item' => $post])
                    @endforeach
                    @if ($posts->hasPages())
                        {{ $posts->withQueryString()->links() }}
                    @endif
                @endif
            </div>
        </div>
    @endif

    {{-- Pending Artikel --}}
    @if (($type === 'all' || $type === 'artikel') && $articles->count())
        <div class="mb-8">
            <h2 class="font-display text-lg font-bold text-ink">Artikel</h2>
            <div class="mt-4 space-y-4">
                @if ($type === 'all')
                    @foreach ($articles as $article)
                        @include('admin.approval._article', ['item' => $article])
                    @endforeach
                @else
                    @foreach ($articles as $article)
                        @include('admin.approval._article', ['item' => $article])
                    @endforeach
                    @if ($articles->hasPages())
                        {{ $articles->withQueryString()->links() }}
                    @endif
                @endif
            </div>
        </div>
    @endif

    {{-- Pending Pengumuman --}}
    @if (($type === 'all' || $type === 'pengumuman') && $announcements->count())
        <div class="mb-8">
            <h2 class="font-display text-lg font-bold text-ink">Pengumuman</h2>
            <div class="mt-4 space-y-4">
                @if ($type === 'all')
                    @foreach ($announcements as $announcement)
                        @include('admin.approval._announcement', ['item' => $announcement])
                    @endforeach
                @else
                    @foreach ($announcements as $announcement)
                        @include('admin.approval._announcement', ['item' => $announcement])
                    @endforeach
                    @if ($announcements->hasPages())
                        {{ $announcements->withQueryString()->links() }}
                    @endif
                @endif
            </div>
        </div>
    @endif

    @if ($totalPending === 0)
        <div class="card grid place-items-center py-20 text-center">
            <x-icon name="clock" class="size-12 text-ink-3"/>
            <p class="mt-4 font-display text-lg font-bold text-ink">Semua sudah disetujui</p>
            <p class="mt-1 text-sm text-ink-2">Tidak ada konten yang menunggu persetujuan.</p>
        </div>
    @endif
@endsection
