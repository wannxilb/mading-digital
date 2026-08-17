@props(['achievement'])

<article class="group relative flex flex-col card card-hover p-5">
    <a href="{{ route('prestasi.show', $achievement) }}" class="absolute inset-0 z-10" aria-label="{{ $achievement->title }}"></a>

    <div class="flex items-start justify-between gap-3">
        <span class="grid size-10 shrink-0 place-items-center rounded-brutal border-2 border-ink bg-acid text-ink">
            <x-icon name="award" class="size-5"/>
        </span>
        @if ($achievement->rank)
            <span class="tag-ink">{{ $achievement->rank }}</span>
        @endif
    </div>

    <h3 class="mt-3 font-display text-base font-bold leading-snug text-ink">{{ $achievement->title }}</h3>

    @if ($achievement->student_name)
        <p class="mt-1 text-sm font-semibold text-ink-2">
            {{ $achievement->student_name }}@if ($achievement->class) · {{ $achievement->class }}@endif
        </p>
    @endif

    @if ($achievement->competition_name)
        <p class="mt-1 text-sm text-ink-2">Lomba: <span class="font-semibold text-ink">{{ $achievement->competition_name }}</span></p>
    @endif

    <div class="mt-auto flex flex-wrap items-center justify-between gap-2 pt-3">
        <span class="tag-blue">{{ $achievement->level_label }}</span>
        <span class="text-xs font-semibold text-ink-3">{{ $achievement->date_label }}</span>
    </div>
</article>
