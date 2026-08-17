@props(['title', 'desc' => null, 'link' => null, 'linkLabel' => 'Lihat Semua'])

<div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h2 class="font-display text-2xl font-bold tracking-tight text-ink sm:text-3xl">{{ $title }}</h2>
        @if ($desc)
            <p class="mt-1.5 max-w-lg text-sm leading-relaxed text-ink-2">{{ $desc }}</p>
        @endif
    </div>
    @if ($link)
        <a href="{{ $link }}" class="btn-ghost shrink-0">
            {{ $linkLabel }}
            <x-icon name="arrow-right" class="size-4"/>
        </a>
    @endif
</div>
