@props([
    'class' => '',
    'image' => false,
    'heading' => false,
    'text' => false,
    'lines' => 1,
    'avatar' => false,
])

@if ($image)
    <div class="skeleton-image aspect-[16/9] border-b-2 border-ink/10 {{ $class }}"></div>
@elseif ($avatar)
    <div class="skeleton-avatar {{ $class }}"></div>
@elseif ($heading)
    <div class="skeleton-heading {{ $class }}"></div>
@elseif ($text)
    <div class="space-y-2 {{ $class }}">
        @for ($i = 0; $i < $lines; $i++)
            <div class="skeleton-text {{ $i === $lines - 1 ? 'w-2/3' : '' }}"></div>
        @endfor
    </div>
@endif
