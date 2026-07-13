@props([
    'icon' => 'bi-inbox',
    'title',
    'description' => null,
])

<div class="kiu-empty-state anim-fade-up {{ $attributes->get('class') }}">
    <div class="kiu-empty-icon"><i class="bi {{ $icon }}"></i></div>
    <div class="fw-semibold fs-5 mb-2">{{ $title }}</div>
    @if($description)
        <p class="text-white-75 mb-3">{{ $description }}</p>
    @endif
    @if(isset($action))
        {{ $action }}
    @endif
</div>
