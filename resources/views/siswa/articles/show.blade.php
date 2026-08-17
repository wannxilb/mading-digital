@extends('layouts.siswa')

@section('title', $article->title)
@section('heading', 'Detail Karya')

@section('content')
    <div class="max-w-4xl">
        <div class="card border-2 p-6 sm:p-8">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        @if ($article->status === 'published')
                            <span class="tag-green">Published</span>
                        @elseif ($article->status === 'review')
                            <span class="tag-amber">Menunggu Review</span>
                        @elseif ($article->status === 'archived')
                            <span class="tag-gray">Arsip</span>
                        @else
                            <span class="tag-gray">Draft</span>
                        @endif
                        <span class="text-xs font-semibold text-ink-3">{{ $article->display_date }}</span>
                    </div>
                    <h2 class="mt-3 font-display text-2xl font-bold text-ink">{{ $article->title }}</h2>
                    <p class="mt-1 text-sm text-ink-2">{{ $article->author }}@if ($article->class) · {{ $article->class }}@endif · {{ $article->category?->name }}</p>
                </div>

                @if (in_array($article->status, ['draft', 'review'], true))
                    <div class="flex shrink-0 gap-2">
                        <a href="{{ route('siswa.karya.edit', $article) }}" class="btn-outline !px-3.5 !py-2 text-xs">
                            <x-icon name="edit" class="size-3.5"/>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('siswa.karya.destroy', $article) }}" onsubmit="return confirm('Hapus karya ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-outline !border-accent !px-3.5 !py-2 text-xs !text-accent">
                                <x-icon name="trash" class="size-3.5"/>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            @if ($article->excerpt)
                <p class="mt-4 text-sm font-semibold text-ink-2 italic">{{ $article->excerpt }}</p>
            @endif

            @if ($article->review_note)
                <div class="mt-4 rounded-brutal border-2 border-accent bg-accent/10 p-4">
                    <p class="text-xs font-bold text-accent">Catatan Reviewer:</p>
                    <p class="mt-1 text-sm text-ink">{{ $article->review_note }}</p>
                </div>
            @endif

            @if ($article->image)
                <div class="mt-6 img-skel relative overflow-hidden rounded-brutal border-2 border-ink bg-paper-deep max-h-[60vh]">
                    <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}" data-adapt class="w-full h-full object-cover">
                </div>
            @endif

            <div class="prose mt-6 max-w-none text-sm leading-relaxed text-ink">
                {!! $article->html !!}
            </div>

            <div class="mt-6 flex items-center gap-4 text-xs font-semibold text-ink-3">
                <span class="flex items-center gap-1"><x-icon name="eye" class="size-3.5"/> {{ number_format($article->views) }} dibaca</span>
            </div>
        </div>
    </div>
@endsection
