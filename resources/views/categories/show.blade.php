@extends('layouts.app')

@section('title', $category->name)
@section('meta_description', $category->description)

@section('content')
    <div class="pt-24 sm:pt-28">
        <section class="relative overflow-hidden bg-white">
            <div class="absolute inset-0 bg-grid-blue"></div>
            <div class="absolute -top-24 -right-24 size-80 rounded-full bg-royal-500/10 blur-3xl"></div>

            <div class="relative mx-auto max-w-6xl px-4 sm:px-6 py-14 sm:py-16">
                <a href="{{ route('home') }}" class="reveal inline-flex items-center gap-2 text-sm font-bold text-royal-600 hover:text-navy-900 transition-colors">
                    <x-icon name="arrow-right" class="size-4 rotate-180"/>
                    Kembali ke Beranda
                </a>
                <div class="reveal mt-6 flex flex-col sm:flex-row sm:items-center gap-5" style="transition-delay:.05s">
                    <span class="grid place-items-center size-16 sm:size-20 shrink-0 rounded-3xl bg-gradient-to-br from-navy-800 to-royal-600 text-white shadow-glow">
                        <x-icon :name="$category->icon" class="size-8 sm:size-10"/>
                    </span>
                    <div>
                        <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight text-navy-900">{{ $category->name }}</h1>
                        <p class="mt-2 max-w-xl text-sm sm:text-base text-navy-900/55">{{ $category->description }}</p>
                        <p class="mt-3 text-xs font-bold text-navy-900/40">{{ $posts->total() }} cerita di halte ini</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-6xl px-4 sm:px-6 py-12 sm:py-16">
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($posts as $post)
                    <div class="reveal" style="transition-delay: {{ min($loop->index, 5) * 0.06 }}s">
                        <x-post-card :post="$post"/>
                    </div>
                @empty
                    <div class="col-span-full grid place-items-center rounded-3xl bg-white ring-1 ring-navy-900/5 py-20 text-center">
                        <x-icon :name="$category->icon" class="size-12 text-royal-500/40"/>
                        <p class="mt-4 font-display font-bold text-lg text-navy-900">Belum ada cerita di halte ini</p>
                        <p class="mt-1 text-sm text-navy-900/55">Tim redaksi sedang menyiapkan cerita terbaru. Tunggu ya!</p>
                        <a href="{{ route('home') }}" class="mt-5 rounded-xl bg-navy-900 px-5 py-2.5 text-xs font-bold text-white hover:bg-navy-800">Kembali ke Beranda</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        </section>
    </div>
@endsection
