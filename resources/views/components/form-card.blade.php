@props(['title', 'backUrl', 'backLabel' => 'Back', 'subtitle' => null])

<div class="kiu-card kiu-form-narrow p-4 anim-fade-up {{ $attributes->get('class') }}">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-white-75 small mb-0">{{ $subtitle }}</p>
            @endif
        </div>
        <a class="btn btn-kiu-ghost" href="{{ $backUrl }}"><i class="bi bi-arrow-left"></i> {{ $backLabel }}</a>
    </div>
    {{ $slot }}
</div>
