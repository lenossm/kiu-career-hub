@extends('layouts.app')

@section('title', 'Opportunities')

@section('content')
    <x-page-header
        title="Student opportunities"
        subtitle="All open positions for KIU students. Match scores help you prioritize — every listing is available to apply."
        icon="bi-briefcase"
    >
        <x-slot:actions>
            <a class="btn btn-kiu-soft" href="{{ route('my.profile.edit') }}"><i class="bi bi-person-gear me-1"></i> My profile</a>
        </x-slot:actions>
        <x-slot:filters>
            <div class="d-flex flex-wrap gap-2 align-items-center w-100">
                <a class="btn btn-kiu-ghost {{ $sort === 'recommended' ? 'active' : '' }}" href="{{ route('student.vacancies.index', array_filter(['sort' => 'recommended', 'q' => $q ?: null])) }}">Best match</a>
                <a class="btn btn-kiu-ghost {{ $sort === 'deadline' ? 'active' : '' }}" href="{{ route('student.vacancies.index', array_filter(['sort' => 'deadline', 'q' => $q ?: null])) }}">By deadline</a>
                <a class="btn btn-kiu-ghost {{ $sort === 'newest' ? 'active' : '' }}" href="{{ route('student.vacancies.index', array_filter(['sort' => 'newest', 'q' => $q ?: null])) }}">Newest</a>
                <form class="d-flex gap-2 ms-lg-auto flex-grow-1 flex-lg-grow-0" method="GET" action="{{ route('student.vacancies.index') }}" style="min-width:240px;">
                    @if($sort !== 'recommended')
                        <input type="hidden" name="sort" value="{{ $sort }}">
                    @endif
                    <div class="input-group kiu-input-group flex-grow-1">
                        <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                        <input class="form-control" name="q" value="{{ $q }}" placeholder="Search vacancies...">
                    </div>
                    <button class="btn btn-kiu-soft" type="submit">Search</button>
                </form>
            </div>
        </x-slot:filters>
    </x-page-header>

    <div class="row g-3">
        @forelse($vacancies as $vacancy)
            @php $score = $scores[$vacancy->id] ?? 0; @endphp
            <div class="col-12 col-lg-6 anim-fade-up">
                <div class="kiu-card kiu-lift h-100 p-4">
                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <div>
                            <span class="kiu-match-badge kiu-match-{{ $score >= 70 ? 'high' : ($score >= 40 ? 'mid' : 'low') }}">
                                <i class="bi bi-lightning-charge"></i> {{ $score }}% match
                            </span>
                            <span class="kiu-badge ms-1">{{ $vacancy->type }}</span>
                        </div>
                        @if($appliedIds->contains($vacancy->id))
                            <span class="kiu-badge kiu-badge-accepted"><i class="bi bi-check2"></i> Applied</span>
                        @endif
                    </div>
                    <h2 class="h5 fw-bold mb-1">
                        <a class="text-decoration-none text-white" href="{{ route('student.vacancies.show', $vacancy) }}">{{ $vacancy->title }}</a>
                    </h2>
                    <div class="small text-muted-soft mb-2">
                        <i class="bi bi-building"></i> {{ $vacancy->company }} · {{ $vacancy->location }}
                        · Deadline {{ $vacancy->deadline->format('M j, Y') }}
                    </div>
                    <p class="small text-muted-soft kiu-clamp-2 mb-3">{{ $vacancy->description }}</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-kiu-neutral btn-sm" href="{{ route('student.vacancies.show', $vacancy) }}">View details</a>
                        @unless($appliedIds->contains($vacancy->id))
                            <a class="btn btn-kiu btn-sm" href="{{ route('student.apply', $vacancy) }}"><i class="bi bi-send me-1"></i> Apply</a>
                        @endunless
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <x-empty-state icon="bi-briefcase" title="No open positions right now" description="New student opportunities will appear here when the career office publishes them.">
                    <x-slot:action>
                        <a class="btn btn-kiu" href="{{ route('my.profile.edit') }}">Update my profile</a>
                    </x-slot:action>
                </x-empty-state>
            </div>
        @endforelse
    </div>

    <x-pagination-info :paginator="$vacancies" class="mt-3" />
@endsection
