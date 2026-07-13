@extends('layouts.app')

@section('title', $vacancy->title)

@section('content')
    <x-page-header
        :title="$vacancy->title"
        subtitle="{{ $vacancy->company }} · {{ $vacancy->location }} · {{ $vacancy->type }}"
        icon="bi-briefcase"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Vacancies', 'url' => route('vacancies.index')],
            ['label' => $vacancy->title, 'url' => route('vacancies.show', $vacancy)],
        ]"
    >
        <x-slot:actions>
            <a class="btn btn-kiu" href="{{ route('vacancies.apply', $vacancy) }}"><i class="bi bi-send me-1"></i> Record application</a>
            @if(auth()->user()->role === 'admin')
                <a class="btn btn-kiu-neutral" href="{{ route('vacancies.edit', $vacancy) }}"><i class="bi bi-pencil"></i></a>
            @endif
        </x-slot:actions>
    </x-page-header>

    <div class="kiu-card p-4 mb-3 anim-fade-up" data-vacancy-id="{{ $vacancy->id }}">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <x-status-badge :status="$vacancy->status === 'done' ? 'done' : 'pending'" data-role="status-badge" />
            <span class="kiu-badge"><i class="bi bi-calendar2-week"></i> Deadline {{ $vacancy->deadline->format('M j, Y') }}</span>
            <span class="kiu-badge"><i class="bi bi-people"></i> {{ $vacancy->applications->count() }} applicants</span>
            @if(auth()->user()->role === 'admin')
                <form method="POST" action="{{ route('vacancies.toggleStatus', $vacancy) }}" class="js-toggle-status ms-lg-auto">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-kiu-status-toggle btn-kiu-sm" type="submit" data-role="toggle-button">
                        {{ $vacancy->status === 'done' ? 'Reopen vacancy' : 'Close vacancy' }}
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="kiu-detail-grid mb-3">
        <div class="kiu-card kiu-detail-panel anim-fade-up">
            <div class="kiu-detail-label">Description</div>
            <div class="kiu-detail-value" style="white-space:pre-wrap;">{{ $vacancy->description }}</div>
        </div>
        <div class="kiu-card kiu-detail-panel anim-fade-up anim-delay-1">
            <div class="kiu-detail-label">Required skills</div>
            <div class="kiu-detail-value" style="white-space:pre-wrap;">{{ $vacancy->required_skills }}</div>
        </div>
    </div>

    <div class="kiu-section-card anim-fade-up">
        <div class="kiu-section-card-header">
            <div class="fw-bold"><i class="bi bi-send-check me-2"></i>Applications for this vacancy</div>
        </div>
        <div class="kiu-section-card-body">
            @if($vacancy->applications->isEmpty())
                <div class="p-4 text-white-75">No applications yet. <a href="{{ route('vacancies.apply', $vacancy) }}">Record the first one</a>.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-dashboard align-middle mb-0">
                        <thead>
                        <tr>
                            <th>Student</th>
                            <th>Status</th>
                            <th>Resume</th>
                            <th class="text-end">Submitted</th>
                            <th class="text-end"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vacancy->applications as $app)
                            <tr>
                                <td>
                                    <a class="text-decoration-none table-dashboard-link fw-semibold" href="{{ route('students.show', $app->student) }}">{{ $app->student->full_name }}</a>
                                    <div class="small table-dashboard-muted">{{ $app->student->faculty }}</div>
                                </td>
                                <td><x-status-badge :status="$app->status" /></td>
                                <td>
                                    @if($app->resume_path)
                                        <span class="kiu-file-pill"><i class="bi bi-file-earmark-pdf"></i> Yes</span>
                                    @else
                                        <span class="kiu-file-pill missing">—</span>
                                    @endif
                                </td>
                                <td class="text-end table-dashboard-cell">{{ $app->created_at->format('M j, Y') }}</td>
                                <td class="text-end">
                                    <a class="btn btn-kiu-neutral btn-kiu-sm" href="{{ route('applications.show', $app) }}">Open</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
