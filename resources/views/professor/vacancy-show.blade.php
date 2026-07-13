@extends('layouts.app')

@section('title', $vacancy->title)

@section('content')
    <x-page-header
        :title="$vacancy->title"
        :subtitle="$vacancy->company.' · Deadline '.$vacancy->deadline->format('M j, Y')"
        icon="bi-building"
        :breadcrumbs="[
            ['label' => 'Opportunities', 'url' => route('professor.portal')],
            ['label' => $vacancy->title, 'url' => route('professor.vacancies.show', $vacancy)],
        ]"
    >
        <x-slot:actions>
            @if($hasApplied)
                <span class="kiu-badge kiu-badge-accepted"><i class="bi bi-check2"></i> Application submitted</span>
            @else
                <a class="btn btn-kiu" href="{{ route('professor.apply', $vacancy) }}"><i class="bi bi-send me-1"></i> Apply</a>
            @endif
        </x-slot:actions>
    </x-page-header>

    <div class="kiu-card p-4 mb-3 anim-fade-up">
        <div class="d-flex flex-wrap gap-2">
            <span class="kiu-badge kiu-badge-professor"><i class="bi bi-building"></i> Internal KIU position</span>
            <span class="kiu-badge">{{ $vacancy->type }}</span>
            <span class="kiu-badge"><i class="bi bi-geo-alt"></i> {{ $vacancy->location }}</span>
        </div>
    </div>

    <div class="kiu-detail-grid">
        <div class="kiu-card kiu-detail-panel anim-fade-up">
            <div class="kiu-detail-label">Position details</div>
            <div class="kiu-detail-value" style="white-space:pre-wrap;">{{ $vacancy->description }}</div>
        </div>
        <div class="kiu-card kiu-detail-panel anim-fade-up anim-delay-1">
            <div class="kiu-detail-label">Requirements</div>
            <div class="kiu-detail-value" style="white-space:pre-wrap;">{{ $vacancy->required_skills }}</div>
        </div>
    </div>
@endsection
