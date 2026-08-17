@props(['event'])

<article class="group relative flex h-full items-stretch card card-hover overflow-hidden">
    <a href="{{ route('agenda.show', $event) }}" class="absolute inset-0 z-10" aria-label="{{ $event->title }}"></a>

    <div class="flex shrink-0 flex-col items-center justify-center border-r-2 border-ink bg-acid px-4 text-ink">
        <span class="font-display text-3xl font-bold leading-none">{{ $event->event_date->format('d') }}</span>
        <span class="mt-1 text-[11px] font-bold uppercase tracking-widest">{{ $event->event_date->translatedFormat('M') }}</span>
    </div>

    <div class="flex flex-1 flex-col gap-1.5 p-5">
        <div class="flex items-center gap-2">
            @php
                $tone = match ($event->status_label) {
                    'Berlangsung' => 'tag-green',
                    'Selesai' => 'tag-gray',
                    default => 'tag-blue',
                };
            @endphp
            <span class="{{ $tone }}">{{ $event->status_label }}</span>
            @if ($event->location)
                <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-ink-3">
                    <x-icon name="location" class="size-3"/>
                    {{ $event->location }}
                </span>
            @endif
        </div>
        <h3 class="font-display text-base font-bold leading-snug text-ink transition-colors group-hover:text-accent">{{ $event->title }}</h3>
        @if ($event->time_label)
            <p class="inline-flex items-center gap-1.5 text-xs font-semibold text-ink-2">
                <x-icon name="clock" class="size-3.5"/>
                {{ $event->time_label }}
            </p>
        @endif
        @if ($event->organizer)
            <p class="mt-auto pt-2 text-xs font-semibold text-ink-3">Penyelenggara: {{ $event->organizer }}</p>
        @endif
    </div>
</article>
