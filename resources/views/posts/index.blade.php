@extends('layouts.app')

@section('title', 'Berita Sekolah')
@section('meta_description', 'Berita dan kegiatan terbaru dari sekolah.')

@section('content')
    <section class="border-b-2 border-ink">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 pt-28 sm:pt-32 pb-10">
            <h1 class="font-display text-4xl font-bold tracking-tight text-ink sm:text-5xl">Berita Sekolah</h1>
            <p class="mt-3 max-w-xl text-sm leading-relaxed text-ink-2 sm:text-base">Berita dan kegiatan terbaru dari sekolah.</p>

            <form method="GET" action="{{ route('berita.index') }}" class="mt-6 max-w-md">
                <div class="relative">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul berita…" class="field border-2 !py-3 pr-20" aria-label="Cari berita">
                    <button type="submit" class="btn-ink absolute right-2 top-1/2 !px-3.5 !py-1.5 -translate-y-1/2 text-xs">Cari</button>
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 sm:px-6 py-12 sm:py-16">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <x-post-card :post="$post" />
            @empty
                <div class="col-span-full card grid place-items-center py-20 text-center">
                    <x-icon name="search" class="size-12 text-ink-3"/>
                    <p class="mt-4 font-display text-lg font-bold text-ink">Belum ada berita</p>
                    <p class="mt-1 max-w-sm text-sm text-ink-2">Coba kata kunci lain, atau kembali lagi nanti.</p>
                </div>
            @endforelse
        </div>

        @if ($posts->hasPages())
            <x-simple-pagination :paginator="$posts" />
        @endif
    </section>
@endsection
