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
    class="kiu-stat-card kiu-stat-{{ $accent }} kiu-lift h-100 text-decoration-none anim-fade-up {{ $attributes->get('class') }}"
>
    <div class="kiu-stat-icon"><i class="bi {{ $icon }}"></i></div>
    <div class="kiu-stat-label">{{ $label }}</div>
    <div class="kiu-stat-value">{{ $value }}</div>
    @if($hint)
        <div class="kiu-stat-hint">{{ $hint }}</div>
    @endif
    @if($href)
        <div class="kiu-stat-link"><i class="bi bi-arrow-right"></i> Open</div>
    @endif
</{{ $tag }}>
