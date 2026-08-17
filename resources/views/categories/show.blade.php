@extends('layouts.app')

@section('title', $category->name)
@section('meta_description', $category->description ?? 'Konten kategori '.$category->name)

@section('content')
    <section class="border-b-2 border-ink">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 pt-28 sm:pt-32 pb-10">
            <h1 class="font-display text-4xl font-bold tracking-tight text-ink sm:text-5xl">{{ $category->name }}</h1>
            @if ($category->description)
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-ink-2 sm:text-base">{{ $category->description }}</p>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 sm:px-6 py-12 sm:py-16">
        @if ($berita->isNotEmpty())
            <p class="kicker mb-5">Berita</p>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($berita as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
        @endif

        @if ($artikel->isNotEmpty())
            <p class="kicker mb-5 mt-12">Artikel Siswa</p>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($artikel as $article)
                    <x-article-card :article="$article" />
                @endforeach
            </div>
        @endif

        @if ($berita->isEmpty() && $artikel->isEmpty())
            <div class="card grid place-items-center py-20 text-center">
                <x-icon name="search" class="size-12 text-ink-3"/>
                <p class="mt-4 font-display text-lg font-bold text-ink">Belum ada konten di kategori ini</p>
                <p class="mt-1 text-sm text-ink-2">Konten yang telah diterbitkan akan tampil di sini.</p>
                <a href="{{ route('home') }}" class="btn-outline mt-6">Kembali ke Beranda</a>
            </div>
        @endif
    </section>
@endsection
