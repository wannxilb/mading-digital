@props(['post'])

<article class="group relative flex h-full flex-col card card-hover">
    <a href="{{ route('berita.show', $post) }}" class="absolute inset-0 z-10" aria-label="Baca {{ $post->title }}"></a>

    <div class="relative aspect-[16/9] overflow-hidden bg-paper-deep">
        @if ($post->image)
            <div class="img-skel relative h-full w-full">
                <div class="skeleton-image absolute inset-0"></div>
                <img data-src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" loading="lazy" decoding="async" class="h-full w-full object-cover opacity-0 transition-opacity duration-500 group-hover:scale-105">
            </div>
        @else
            <div class="absolute bottom-3 left-4 right-4">
                <span class="font-display text-lg font-bold leading-tight text-ink line-clamp-2">{{ $post->title }}</span>
            </div>
        @endif

        @if ($post->is_featured)
            <span class="absolute right-3 top-3 z-20 tag-ink">
                Unggulan
            </span>
        @endif
    </div>

    <div class="flex flex-1 flex-col gap-2 p-5">
        <div class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-ink-3">
            <span class="text-accent">{{ $post->category?->name }}</span>
            <span>·</span>
            <span>{{ $post->display_date }}</span>
        </div>

        @unless ($post->image)
            <h3 class="font-display text-lg font-bold leading-snug text-ink line-clamp-2 transition-colors group-hover:text-accent">{{ $post->title }}</h3>
        @endunless

        <p class="text-sm leading-relaxed text-ink-2 line-clamp-3">{{ $post->excerpt ?: Str::limit(strip_tags($post->body), 130) }}</p>

        <div class="mt-auto flex items-center justify-between border-t-2 border-ink/10 pt-3 text-xs font-semibold text-ink-2">
            <span class="truncate">{{ $post->author }}</span>
            <span class="inline-flex shrink-0 items-center gap-1.5">
                <x-icon name="eye" class="size-3.5"/>
                {{ number_format($post->views) }}
            </span>
        </div>
    </div>
</article>
