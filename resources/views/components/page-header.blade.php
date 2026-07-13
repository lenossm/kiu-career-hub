@props([
    'title',
    'subtitle' => null,
    'icon' => null,
    'breadcrumbs' => [],
])

<div class="kiu-page-header anim-fade-up {{ $attributes->get('class') }}">
    @if(count($breadcrumbs) > 0)
        <nav class="kiu-breadcrumb mb-2" aria-label="Breadcrumb">
            @foreach($breadcrumbs as $crumb)
                @if($loop->last)
                    <span class="kiu-breadcrumb-current">{{ $crumb['label'] }}</span>
                @else
                    <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                    <i class="bi bi-chevron-right"></i>
                @endif
            @endforeach
        </nav>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div class="d-flex align-items-start gap-3" style="min-width:0;">
            @if($icon)
                <div class="kiu-page-icon" aria-hidden="true">
                    <i class="bi {{ $icon }}"></i>
                </div>
            @endif
            <div style="min-width:0;">
                <h1 class="h3 fw-bold mb-1 kiu-title">{{ $title }}</h1>
                @if($subtitle)
                    <p class="kiu-meta mb-0">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
        @if(isset($actions))
            <div class="d-flex flex-wrap gap-2 align-items-center">
                {{ $actions }}
            </div>
        @endif
    </div>

    @if(isset($filters))
        <div class="mt-3 pt-3 kiu-page-header-divider">
            {{ $filters }}
        </div>
    @endif
</div>
