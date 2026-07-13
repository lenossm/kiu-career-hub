@props([
    'label',
    'value',
    'icon',
    'href' => null,
    'hint' => null,
    'accent' => 'blue',
])

@php
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->class([
        'kiu-stat-card',
        'kiu-stat-'.$accent,
        'h-100',
        'text-decoration-none',
        'anim-pop',
    ]) }}
>
    <div class="kiu-stat-top">
        <span class="kiu-stat-icon" aria-hidden="true"><i class="bi {{ $icon }}"></i></span>
        @if($href)
            <span class="kiu-stat-open">Open <i class="bi bi-arrow-right"></i></span>
        @endif
    </div>

    <div class="kiu-stat-body">
        <div class="kiu-stat-label">{{ $label }}</div>
        <div class="kiu-stat-value">{{ $value }}</div>
    </div>

    @if($hint)
        <div class="kiu-stat-foot">
            <span class="kiu-stat-hint">{{ $hint }}</span>
        </div>
    @endif
</{{ $tag }}>
