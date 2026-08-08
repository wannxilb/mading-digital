@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', $post->excerpt)

@section('content')
    <div class="pt-24 sm:pt-28">
        <article class="mx-auto max-w-3xl px-4 sm:px-6">
            <header class="text-center">
                <a href="{{ route('category', $post->category) }}"
                   class="reveal inline-flex items-center gap-2 rounded-full bg-ice-100 px-4 py-1.5 text-xs font-bold text-royal-600 ring-1 ring-royal-500/20 transition-colors hover:bg-royal-600 hover:text-white">
                    <x-icon :name="$post->category?->icon ?? 'sparkle'" class="size-3.5"/>
                    {{ $post->category?->name }}
                </a>

                <h1 class="reveal mt-5 font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold leading-tight tracking-tight text-navy-900 text-balance" style="transition-delay:.05s">{{ $post->title }}</h1>

                <div class="reveal mt-6 flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-xs sm:text-sm font-semibold text-navy-900/55" style="transition-delay:.1s">
                    <span class="inline-flex items-center gap-2">
                        <span class="grid place-items-center size-8 rounded-full bg-navy-900 text-white text-[11px] font-bold">{{ Str::upper(Str::substr($post->author, 0, 1)) }}</span>
                        {{ $post->author }}
                    </span>
                    <span class="inline-flex items-center gap-1.5"><x-icon name="clock" class="size-4"/>{{ $post->display_date }}</span>
                    <span class="inline-flex items-center gap-1.5"><x-icon name="eye" class="size-4"/>{{ number_format($post->views) }} dibaca</span>
                </div>
            </header>

            @if ($post->image)
                <figure class="reveal mt-10 overflow-hidden rounded-3xl shadow-lift" style="transition-delay:.15s">
                    <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" class="w-full object-cover">
                </figure>
            @endif

            <div class="reveal relative mt-12 border-l-4 border-royal-500 bg-ice-100/70 rounded-r-2xl p-5 sm:p-6" style="transition-delay:.18s">
                <div class="flex gap-3">
                    <x-icon name="quote" class="size-5 text-royal-600 shrink-0"/>
                    <p class="text-sm sm:text-base font-medium leading-relaxed text-navy-800">{{ $post->excerpt }}</p>
                </div>
            </div>

            <div class="reveal prose-wrap mt-10 text-navy-900/80 text-base sm:text-lg leading-[1.9]" style="transition-delay:.2s">
                {!! $post->html !!}
            </div>

            <div class="reveal mt-12 flex flex-col sm:flex-row items-center justify-between gap-4 rounded-2xl bg-white ring-1 ring-navy-900/5 p-5 shadow-soft" style="transition-delay:.25s">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="grid place-items-center size-10 shrink-0 rounded-full bg-gradient-to-br from-navy-800 to-royal-600 text-white text-xs font-bold">{{ Str::upper(Str::substr($post->author, 0, 1)) }}</span>
                    <div class="min-w-0">
                        <p class="text-sm font-bold text-navy-900 truncate">{{ $post->author }}</p>
                        <p class="text-xs text-navy-900/50">Penulis cerita ini</p>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="group inline-flex shrink-0 items-center gap-2 rounded-xl bg-navy-900 px-5 py-3 text-xs font-bold text-white hover:bg-navy-800 transition-colors">
                    <x-icon name="arrow-right" class="size-4 rotate-180 transition-transform group-hover:-translate-x-1"/>
                    Kembali ke Papan
                </a>
            </div>
        </article>

        @if ($related->isNotEmpty())
            <section class="mx-auto max-w-6xl px-4 sm:px-6 pt-16 pb-4">
                <div class="reveal flex items-end justify-between gap-4">
                    <div>
                        <h2 class="font-display text-xl sm:text-2xl font-extrabold tracking-tight text-navy-900">Cerita Serupa</h2>
                        <p class="mt-1 text-sm text-navy-900/55">Masih dalam halte {{ $post->category?->name }}.</p>
                    </div>
                    <a href="{{ route('category', $post->category) }}" class="group inline-flex shrink-0 items-center gap-2 rounded-xl bg-ice-100 px-4 py-2.5 text-xs font-bold text-navy-900 hover:bg-royal-600 hover:text-white transition-colors">
                        Semua {{ $post->category?->name }}
                        <x-icon name="arrow-right" class="size-3.5 transition-transform group-hover:translate-x-0.5"/>
                    </a>
                </div>
                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($related as $relatedPost)
                        <div class="reveal" style="transition-delay: {{ $loop->index * 0.07 }}s">
                            <x-post-card :post="$relatedPost"/>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
