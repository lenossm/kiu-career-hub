@props(['status'])

@php
    $normalized = strtolower($status);
    $class = match ($normalized) {
        'pending' => 'kiu-badge-pending',
        'done', 'closed' => 'kiu-badge-closed',
        'reviewed' => 'kiu-badge-reviewed',
        'accepted' => 'kiu-badge-accepted',
        'rejected' => 'kiu-badge-rejected',
        default => '',
    };
    $icon = match ($normalized) {
        'pending' => 'bi-hourglass-split',
        'done', 'closed' => 'bi-check-circle',
        'reviewed' => 'bi-eye',
        'accepted' => 'bi-hand-thumbs-up',
        'rejected' => 'bi-x-circle',
        default => 'bi-circle',
    };
@endphp

<span {{ $attributes->merge(['class' => "kiu-badge {$class}"]) }}>
    <i class="bi {{ $icon }}"></i>
    {{ ucfirst($normalized) }}
</span>
