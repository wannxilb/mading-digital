@props(['post'])

<article class="group relative flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-soft ring-1 ring-navy-900/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-lift hover:ring-royal-500/20">
    <a href="{{ route('post.show', $post) }}" class="absolute inset-0 z-10" aria-label="Baca {{ $post->title }}"></a>

    <div class="relative h-44 overflow-hidden bg-gradient-to-br from-navy-800 via-royal-600 to-sky-500 sm:h-48">
        @if ($post->image)
            <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" loading="lazy" decoding="async" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
        @else
            <div class="absolute inset-0 bg-grid-blue opacity-40"></div>
            <div class="absolute -right-8 -bottom-10 text-white/15 rotate-12 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-6">
                <x-icon :name="$post->category?->icon ?? 'sparkle'" class="size-40" stroke-width="1.4"/>
            </div>
            <div class="absolute -left-6 -top-8 size-28 rounded-full bg-sky-400/25 blur-2xl"></div>
            <div class="absolute right-4 bottom-4 left-4">
                <h3 class="font-display text-lg font-bold leading-snug text-white text-balance drop-shadow-sm line-clamp-2">{{ $post->title }}</h3>
            </div>
        @endif

        <span class="absolute top-3.5 left-3.5 inline-flex items-center gap-1.5 rounded-full bg-white/90 backdrop-blur px-2.5 py-1 text-[11px] font-bold text-royal-600 shadow-sm">
            <x-icon :name="$post->category?->icon ?? 'sparkle'" class="size-3.5"/>
            {{ $post->category?->name }}
        </span>

        @if ($post->is_featured)
            <span class="absolute top-3.5 right-3.5 inline-flex items-center gap-1 rounded-full bg-navy-900/90 backdrop-blur px-2.5 py-1 text-[11px] font-bold text-white">
                <x-icon name="trophy" class="size-3.5"/>
                Unggulan
            </span>
        @endif
    </div>

    <div class="flex flex-1 flex-col gap-3 p-5">
        @unless ($post->image)
            <h3 class="font-display text-base font-bold leading-snug text-navy-900 line-clamp-2 transition-colors group-hover:text-royal-600">{{ $post->title }}</h3>
        @endunless

        <p class="text-sm leading-relaxed text-navy-900/60 line-clamp-3">{{ $post->excerpt ?: Str::limit(strip_tags($post->body), 120) }}</p>

        <div class="mt-auto flex items-center justify-between gap-3 pt-3 text-xs font-medium text-navy-900/50">
            <span class="inline-flex items-center gap-1.5 min-w-0">
                <x-icon name="clock" class="size-3.5 shrink-0"/>
                <span class="truncate">{{ $post->display_date }}</span>
            </span>
            <span class="inline-flex items-center gap-1.5 shrink-0">
                <x-icon name="eye" class="size-3.5"/>
                {{ number_format($post->views) }}
            </span>
        </div>
    </div>

    <div class="relative z-20 flex items-center justify-between border-t border-navy-900/5 bg-ice-50/60 px-5 py-3">
        <span class="inline-flex items-center gap-2 text-xs font-semibold text-navy-800 min-w-0">
            <span class="grid place-items-center size-6 rounded-full bg-royal-600/10 text-royal-600">
                <x-icon name="map-pin" class="size-3.5"/>
            </span>
            <span class="truncate">{{ $post->author }}</span>
        </span>
        <span class="inline-flex items-center gap-1 text-xs font-bold text-royal-600 transition-transform duration-300 group-hover:translate-x-1">
            Baca
            <x-icon name="arrow-right" class="size-3.5"/>
        </span>
    </div>
</article>
