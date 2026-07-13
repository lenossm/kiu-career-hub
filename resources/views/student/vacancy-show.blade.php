@extends('layouts.app')

@section('title', $vacancy->title)

@section('content')
    <x-page-header
        :title="$vacancy->title"
        :subtitle="$vacancy->company.' · '.$vacancy->location.' · '.$vacancy->type"
        icon="bi-briefcase"
        :breadcrumbs="[
            ['label' => 'Opportunities', 'url' => route('student.vacancies.index')],
            ['label' => $vacancy->title, 'url' => route('student.vacancies.show', $vacancy)],
        ]"
    >
        <x-slot:actions>
            @if($hasApplied)
                <span class="kiu-badge kiu-badge-accepted"><i class="bi bi-check2"></i> Application submitted</span>
            @else
                <a class="btn btn-kiu" href="{{ route('student.apply', $vacancy) }}"><i class="bi bi-send me-1"></i> Apply now</a>
            @endif
        </x-slot:actions>
    </x-page-header>

    <div class="kiu-card p-4 mb-3 anim-fade-up">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="kiu-match-badge kiu-match-{{ $score >= 70 ? 'high' : ($score >= 40 ? 'mid' : 'low') }}">
                <i class="bi bi-lightning-charge"></i> {{ $score }}% skill match
            </span>
            <span class="kiu-badge"><i class="bi bi-calendar2-week"></i> Deadline {{ $vacancy->deadline->format('M j, Y') }}</span>
            <span class="kiu-badge"><i class="bi bi-mortarboard"></i> For students</span>
        </div>
    </div>

    <div class="kiu-detail-grid">
        <div class="kiu-card kiu-detail-panel anim-fade-up">
            <div class="kiu-detail-label">About this role</div>
            <div class="kiu-detail-value" style="white-space:pre-wrap;">{{ $vacancy->description }}</div>
        </div>
        <div class="kiu-card kiu-detail-panel anim-fade-up anim-delay-1">
            <div class="kiu-detail-label">Required skills</div>
            <div class="kiu-detail-value" style="white-space:pre-wrap;">{{ $vacancy->required_skills }}</div>
        </div>
    </div>
@endsection
