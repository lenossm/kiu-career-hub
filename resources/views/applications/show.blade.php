@extends('layouts.app')

@section('title', 'Application')

@section('content')
    <x-page-header
        :title="$application->vacancy->title"
        :subtitle="$application->student->full_name.' · '.$application->vacancy->company"
        icon="bi-send-check"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Applications', 'url' => route('applications.index')],
            ['label' => 'Details', 'url' => route('applications.show', $application)],
        ]"
    >
        <x-slot:actions>
            @if(auth()->user()->role === 'admin')
                <a class="btn btn-kiu" href="{{ route('applications.edit', $application) }}"><i class="bi bi-pencil me-1"></i> Edit status</a>
                <form method="POST" action="{{ route('applications.destroy', $application) }}" onsubmit="return confirm('Delete this application?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-kiu-danger-outline" type="submit"><i class="bi bi-trash"></i></button>
                </form>
            @endif
        </x-slot:actions>
    </x-page-header>

    <div class="kiu-detail-grid">
        <div class="kiu-card kiu-detail-panel anim-fade-up">
            <div class="kiu-detail-label"><i class="bi bi-chat-left-text me-1"></i> Cover letter</div>
            <div class="kiu-detail-value" style="white-space:pre-wrap;">{{ $application->cover_letter }}</div>
        </div>
        <div class="kiu-card kiu-detail-panel anim-fade-up anim-delay-1">
            <div class="mb-3">
                <div class="kiu-detail-label">Status</div>
                <x-status-badge :status="$application->status" />
            </div>
            <div class="mb-3">
                <div class="kiu-detail-label">Student</div>
                <a class="text-decoration-none table-dashboard-link" href="{{ route('students.show', $application->student) }}">{{ $application->student->full_name }}</a>
                <div class="small text-white-65">{{ $application->student->faculty }}</div>
            </div>
            <div class="mb-3">
                <div class="kiu-detail-label">Vacancy</div>
                <a class="text-decoration-none table-dashboard-link" href="{{ route('vacancies.show', $application->vacancy) }}">{{ $application->vacancy->title }}</a>
            </div>
            <div class="mb-3">
                <div class="kiu-detail-label">Submitted</div>
                <div class="kiu-detail-value">{{ $application->created_at->format('M j, Y · H:i') }}</div>
            </div>
            <div>
                <div class="kiu-detail-label">Resume</div>
                @if($application->resume_path)
                    <a class="btn btn-kiu-soft w-100" href="{{ asset('storage/'.$application->resume_path) }}" target="_blank" rel="noopener">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Download resume
                    </a>
                @else
                    <div class="text-white-65 small">No resume uploaded.</div>
                @endif
            </div>
        </div>
    </div>
@endsection
