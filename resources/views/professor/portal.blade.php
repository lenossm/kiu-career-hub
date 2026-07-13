@extends('layouts.app')

@section('title', 'Faculty Portal')

@section('content')
    <x-page-header
        title="Faculty opportunities"
        subtitle="All internal KIU positions open to professors and teaching assistants."
        icon="bi-building"
    >
        <x-slot:actions>
            <a class="btn btn-kiu-soft" href="{{ route('professor.profile.edit') }}"><i class="bi bi-person-gear me-1"></i> My profile</a>
        </x-slot:actions>
        <x-slot:filters>
            <form class="d-flex gap-2" method="GET" action="{{ route('professor.portal') }}">
                <div class="input-group kiu-input-group flex-grow-1">
                    <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                    <input class="form-control" name="q" value="{{ $q }}" placeholder="Search internal positions...">
                </div>
                <button class="btn btn-kiu-soft" type="submit">Search</button>
            </form>
        </x-slot:filters>
    </x-page-header>

    <div class="kiu-card p-3 mb-3 anim-fade-up">
        <div class="fw-semibold">{{ $professor->full_name }}</div>
        <div class="small text-muted-soft">{{ $professor->department }} · {{ $professor->email }}</div>
    </div>

    <div class="row g-3">
        @forelse($vacancies as $vacancy)
            <div class="col-12 col-lg-6 anim-fade-up">
                <div class="kiu-card kiu-lift h-100 p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="kiu-badge kiu-badge-professor"><i class="bi bi-building"></i> Internal KIU</span>
                        @if($appliedIds->contains($vacancy->id))
                            <span class="kiu-badge kiu-badge-accepted">Applied</span>
                        @endif
                    </div>
                    <h2 class="h5 fw-bold">{{ $vacancy->title }}</h2>
                    <div class="small text-muted-soft mb-2">{{ $vacancy->company }} · Deadline {{ $vacancy->deadline->format('M j, Y') }}</div>
                    <p class="small kiu-clamp-3 text-muted-soft mb-3">{{ $vacancy->description }}</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-kiu-neutral btn-sm" href="{{ route('professor.vacancies.show', $vacancy) }}">View details</a>
                        @unless($appliedIds->contains($vacancy->id))
                            <a class="btn btn-kiu btn-sm" href="{{ route('professor.apply', $vacancy) }}">Apply</a>
                        @endunless
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><x-empty-state icon="bi-inbox" title="No faculty vacancies" description="The career office has not posted internal roles yet." /></div>
        @endforelse
    </div>

    <x-pagination-info :paginator="$vacancies" class="mt-3" />
@endsection
