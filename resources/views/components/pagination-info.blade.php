@props(['paginator'])

@if($paginator->count() > 0)
    <div class="kiu-pagination-footer anim-fade-up {{ $attributes->get('class') }}">
        {{ $paginator->withQueryString()->links('pagination::bootstrap-5') }}
        <div class="small text-white-65 mt-2">
            Page {{ $paginator->currentPage() }} of {{ max(1, $paginator->lastPage()) }}
            · Showing {{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }}
        </div>
    </div>
@endif
