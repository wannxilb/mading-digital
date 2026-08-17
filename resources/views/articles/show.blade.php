@extends('layouts.app')

@section('title', $article->title)
@section('meta_description', $article->excerpt ?? Str::limit(strip_tags($article->body), 150))

@section('content')
    <article class="mx-auto max-w-3xl px-4 sm:px-6 pt-28 sm:pt-32">
        <a href="{{ route('artikel.index') }}" class="btn-ghost text-xs">
            <x-icon name="arrow-left" class="size-4"/>
            Kembali ke Artikel
        </a>

        <header class="mt-6">
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('category', $article->category) }}" class="chip">
                    {{ $article->category?->name }}
                </a>
            </div>

            <h1 class="mt-5 font-display text-3xl font-bold leading-tight tracking-tight text-ink text-balance sm:text-4xl sm:leading-tight">{{ $article->title }}</h1>

            <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-2 border-y-2 border-ink/10 py-4 text-sm font-semibold text-ink-2">
                <span class="inline-flex items-center gap-2">
                    <span class="grid size-8 place-items-center rounded-brutal border-2 border-ink bg-blue font-display text-xs font-bold text-cream">{{ Str::upper(Str::substr($article->author, 0, 1)) }}</span>
                    {{ $article->author }}@if ($article->class) · {{ $article->class }}@endif
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <x-icon name="calendar" class="size-4 text-ink-3"/>
                    {{ $article->display_date }}
                </span>
                <span class="inline-flex items-center gap-1.5">
                    <x-icon name="eye" class="size-4 text-ink-3"/>
                    {{ number_format($article->views) }} kali dibaca
                </span>
            </div>
        </header>

        @if ($article->image)
            <figure class="mt-8">
                <div class="img-skel relative overflow-hidden rounded-brutal border-2 border-ink bg-paper-deep max-h-[70vh]">
                    <div class="skeleton-image aspect-[16/9]"></div>
                    <img data-src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}" data-adapt class="w-full h-full object-cover opacity-0 transition-opacity duration-500">
                </div>
            </figure>
        @endif

        <div class="prose-wrap mt-10">
            {!! $article->html !!}
        </div>
    </article>

    <div class="mx-auto max-w-3xl px-4 sm:px-6 mt-12">
        <div class="post-nav">
            @if ($prev)
                <a href="{{ route('artikel.show', $prev) }}">
                    <span class="post-nav-icon"><x-icon name="arrow-left" class="size-4"/></span>
                    <span class="flex-1 min-w-0">
                        <span class="post-nav-label">Artikel Sebelumnya</span>
                        <span class="post-nav-title">{{ $prev->title }}</span>
                    </span>
                </a>
            @else
                <a href="#">
                    <span class="post-nav-empty">Tidak ada artikel sebelumnya</span>
                </a>
            @endif

            @if ($next)
                <a href="{{ route('artikel.show', $next) }}" class="sm:text-right">
                    <span class="post-nav-icon sm:order-last"><x-icon name="arrow-right" class="size-4"/></span>
                    <span class="flex-1 min-w-0 sm:order-first">
                        <span class="post-nav-label">Artikel Selanjutnya</span>
                        <span class="post-nav-title">{{ $next->title }}</span>
                    </span>
                </a>
            @else
                <a href="#" class="sm:text-right">
                    <span class="post-nav-empty">Tidak ada artikel selanjutnya</span>
                </a>
            @endif
        </div>
    </div>

    @if ($related->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 sm:px-6 py-16 sm:py-20">
            <div class="flex items-end justify-between gap-4">
                <h2 class="font-display text-2xl font-bold tracking-tight text-ink sm:text-3xl">Artikel Terkait</h2>
                <a href="{{ route('artikel.index') }}" class="btn-ghost shrink-0">Semua Artikel</a>
            </div>
            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($related as $rel)
                    <x-article-card :article="$rel" />
                @endforeach
            </div>
        </section>
    @endif
@endsection
