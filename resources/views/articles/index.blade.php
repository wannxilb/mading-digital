@extends('layouts.app')

@section('title', 'Artikel & Karya Siswa')
@section('meta_description', 'Tulisan siswa: cerpen, puisi, opini, dan lainnya.')

@section('content')
    <section class="border-b-2 border-ink">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 pt-28 sm:pt-32 pb-10">
            <h1 class="font-display text-4xl font-bold tracking-tight text-ink sm:text-5xl">Artikel & Karya Siswa</h1>
            <p class="mt-3 max-w-xl text-sm leading-relaxed text-ink-2 sm:text-base">Tulisan dari siswa: cerpen, puisi, opini, tips belajar, ulasan buku, dan sebagainya.</p>

            <form method="GET" action="{{ route('artikel.index') }}" class="mt-6 max-w-md">
                <div class="relative">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul artikel…" class="field border-2 !py-3 pr-20" aria-label="Cari artikel">
                    <button type="submit" class="btn-ink absolute right-2 top-1/2 !px-3.5 !py-1.5 -translate-y-1/2 text-xs">Cari</button>
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 sm:px-6 py-12 sm:py-16">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($articles as $article)
                <x-article-card :article="$article" />
            @empty
                <div class="col-span-full card grid place-items-center py-20 text-center">
                    <x-icon name="pen" class="size-12 text-ink-3"/>
                    <p class="mt-4 font-display text-lg font-bold text-ink">Belum ada artikel</p>
                    <p class="mt-1 max-w-sm text-sm text-ink-2">Artikel yang telah disetujui akan tampil di sini.</p>
                </div>
            @endforelse
        </div>

        @if ($articles->hasPages())
            <x-simple-pagination :paginator="$articles" />
        @endif
    </section>
@endsection
