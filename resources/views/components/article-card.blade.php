@props(['article'])

<article class="group relative flex h-full flex-col card card-hover">
    <a href="{{ route('artikel.show', $article) }}" class="absolute inset-0 z-10" aria-label="Baca {{ $article->title }}"></a>

    <div class="relative aspect-[16/9] overflow-hidden bg-paper-deep">
        @if ($article->image)
            <div class="img-skel relative h-full w-full">
                <div class="skeleton-image absolute inset-0"></div>
                <img data-src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}" loading="lazy" decoding="async" class="h-full w-full object-cover opacity-0 transition-opacity duration-500 group-hover:scale-105">
            </div>
        @else
            <div class="absolute bottom-3 left-4 right-4">
                <span class="font-display text-lg font-bold leading-tight text-ink line-clamp-2">{{ $article->title }}</span>
            </div>
        @endif
    </div>

    <div class="flex flex-1 flex-col gap-2 p-5">
        <div class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-ink-3">
            <span class="text-blue">{{ $article->category?->name }}</span>
            <span>·</span>
            <span>{{ $article->display_date }}</span>
        </div>

        <h3 class="font-display text-lg font-bold leading-snug text-ink line-clamp-2 transition-colors group-hover:text-accent">{{ $article->title }}</h3>

        <p class="text-sm leading-relaxed text-ink-2 line-clamp-3">{{ $article->excerpt ?: Str::limit(strip_tags($article->body), 130) }}</p>

        <div class="mt-auto flex items-center justify-between border-t-2 border-ink/10 pt-3 text-xs font-semibold text-ink-2">
            <span class="truncate">{{ $article->author }}@if ($article->class) ({{ $article->class }})@endif</span>
            <span class="inline-flex shrink-0 items-center gap-1.5">
                <x-icon name="eye" class="size-3.5"/>
                {{ number_format($article->views) }}
            </span>
        </div>
    </div>
</article>
