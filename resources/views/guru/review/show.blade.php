@extends('layouts.guru')

@section('title', 'Review: '.$article->title)
@section('heading', 'Review Artikel')

@section('content')
    <div class="max-w-4xl">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="card border-2 p-6 sm:p-8">
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

                    @if ($article->user)
                        <p class="mt-1 text-xs text-ink-3">Dikirim oleh: {{ $article->user->name }} ({{ $article->user->email }})</p>
                    @endif

                    @if ($article->excerpt)
                        <p class="mt-4 text-sm font-semibold text-ink-2 italic">{{ $article->excerpt }}</p>
                    @endif

                    @if ($article->image)
                        <div class="mt-6 img-skel relative overflow-hidden rounded-brutal border-2 border-ink bg-paper-deep max-h-[60vh]">
                            <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}" data-adapt class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div class="prose mt-6 max-w-none text-sm leading-relaxed text-ink">
                        {!! $article->html !!}
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                @if ($article->status === 'review')
                    <div class="card border-2 p-6">
                        <h3 class="font-display text-lg font-bold text-ink">Keputusan Review</h3>

                        <form method="POST" action="{{ route('guru.review.approve', $article) }}" class="mt-4">
                            @csrf
                            <button type="submit" class="btn-green w-full !py-3.5" onclick="return confirm('Publikasikan artikel ini?')">
                                <x-icon name="check-circle" class="size-4"/>
                                Approve & Publikasikan
                            </button>
                        </form>

                        <form method="POST" action="{{ route('guru.review.reject', $article) }}" class="mt-3" onsubmit="return confirm('Tolak artikel ini?')">
                            @csrf
                            <div>
                                <label for="review_note" class="label">Catatan Penolakan <span class="text-accent">*</span></label>
                                <textarea id="review_note" name="review_note" rows="3" required class="field mt-2" placeholder="Jelaskan alasan penolakan...">{{ old('review_note') }}</textarea>
                                @error('review_note')<p class="mt-2 text-xs font-bold text-accent">{{ $message }}</p>@enderror
                            </div>
                            <button type="submit" class="btn-red mt-3 w-full !py-3.5">
                                <x-icon name="x-circle" class="size-4"/>
                                Tolak & Arsipkan
                            </button>
                        </form>
                    </div>
                @endif

                @if ($article->review_note && $article->status !== 'review')
                    <div class="card border-2 border-accent p-6">
                        <h3 class="font-display text-sm font-bold text-accent">Catatan Reviewer</h3>
                        <p class="mt-2 text-sm text-ink">{{ $article->review_note }}</p>
                    </div>
                @endif

                <div class="card border-2 p-6">
                    <h3 class="font-display text-lg font-bold text-ink">Detail</h3>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="font-semibold text-ink-3">Status</dt>
                            <dd class="font-bold text-ink">{{ $article->status_label }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-semibold text-ink-3">Kategori</dt>
                            <dd class="font-bold text-ink">{{ $article->category?->name ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-semibold text-ink-3">Dibaca</dt>
                            <dd class="font-bold text-ink">{{ number_format($article->views) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-semibold text-ink-3">Dibuat</dt>
                            <dd class="font-bold text-ink">{{ $article->created_at->translatedFormat('d M Y H:i') }}</dd>
                        </div>
                        @if ($article->published_at)
                            <div class="flex justify-between">
                                <dt class="font-semibold text-ink-3">Dipublikasikan</dt>
                                <dd class="font-bold text-ink">{{ $article->published_at->translatedFormat('d M Y H:i') }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
