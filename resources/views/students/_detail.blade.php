@php
    $self = $self ?? false;
    $initials = collect(preg_split('/\s+/', trim($student->full_name)))->filter()->take(2)->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->join('');
@endphp

<x-page-header
    :title="$student->full_name"
    :subtitle="$self ? 'Your public career profile at KIU.' : 'Student profile at KIU — skills, experience, and application history.'"
    icon="bi-person-badge"
    :breadcrumbs="$self ? [
        ['label' => 'Opportunities', 'url' => route('student.vacancies.index')],
        ['label' => 'My profile', 'url' => route('my.profile.show')],
    ] : [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Students', 'url' => route('students.index')],
        ['label' => $student->full_name, 'url' => route('students.show', $student)],
    ]"
>
    <x-slot:actions>
        @if($student->github_link)
            <a class="btn btn-kiu-soft btn-kiu-sm" target="_blank" rel="noopener" href="{{ $student->github_link }}"><i class="bi bi-github"></i></a>
        @endif
        @if($student->linkedin_link)
            <a class="btn btn-kiu-soft btn-kiu-sm" target="_blank" rel="noopener" href="{{ $student->linkedin_link }}"><i class="bi bi-linkedin"></i></a>
        @endif
        @if($student->portfolio_link)
            <a class="btn btn-kiu-soft btn-kiu-sm" target="_blank" rel="noopener" href="{{ $student->portfolio_link }}"><i class="bi bi-link-45deg"></i></a>
        @endif
        @if($self)
            <a class="btn btn-kiu" href="{{ route('my.profile.edit') }}"><i class="bi bi-pencil me-1"></i> Edit profile</a>
        @endif
    </x-slot:actions>
</x-page-header>

<div class="kiu-card p-4 mb-3 anim-fade-up">
    <div class="d-flex align-items-center gap-3">
        @if($student->photo_path)
            <img src="{{ asset('storage/'.$student->photo_path) }}" alt="{{ $student->full_name }}" class="kiu-student-photo" style="width:72px;height:72px;border-radius:18px;">
        @else
            <div class="kiu-avatar" style="width:72px;height:72px;font-size:1.25rem;">{{ $initials }}</div>
        @endif
        <div>
            <div class="d-flex flex-wrap gap-2 mb-1">
                <span class="kiu-badge"><i class="bi bi-mortarboard"></i> {{ $student->faculty }}</span>
                <span class="kiu-badge"><i class="bi bi-envelope"></i> {{ $student->email }}</span>
                <span class="kiu-badge"><i class="bi bi-send-check"></i> {{ $student->applications->count() }} applications</span>
            </div>
        </div>
    </div>
</div>

<div class="kiu-detail-grid mb-3">
    <div class="kiu-card kiu-detail-panel anim-fade-up">
        <div class="kiu-detail-label"><i class="bi bi-person-lines-fill me-1"></i> About</div>
        <div class="kiu-detail-value" style="white-space:pre-wrap;">{{ $student->short_bio }}</div>
        <div class="kiu-detail-label mt-4"><i class="bi bi-stars me-1"></i> Skills</div>
        <div class="mb-2">
            @foreach(collect(explode(',', $student->skills))->map(fn($s)=>trim($s))->filter() as $skill)
                <span class="kiu-skill-chip">{{ $skill }}</span>
            @endforeach
        </div>
    </div>
    <div class="kiu-card kiu-detail-panel anim-fade-up anim-delay-1">
        <div class="kiu-detail-label"><i class="bi bi-briefcase me-1"></i> Experience</div>
        <div class="kiu-detail-value" style="white-space:pre-wrap;">{{ $student->experience ?: 'No experience listed yet.' }}</div>
    </div>
</div>

<div class="kiu-section-card anim-fade-up">
    <div class="kiu-section-card-header">
        <div class="fw-bold"><i class="bi bi-send-check me-2"></i>Application history</div>
    </div>
    <div class="kiu-section-card-body">
        @if($student->applications->isEmpty())
            <div class="kiu-empty-inline">No applications yet.</div>
        @else
            <div class="table-responsive">
                <table class="table table-dashboard align-middle mb-0">
                    <thead>
                    <tr>
                        <th>Vacancy</th>
                        <th>Status</th>
                        <th>Resume</th>
                        <th class="text-end">Submitted</th>
                        @unless($self)
                            <th class="text-end"></th>
                        @endunless
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($student->applications as $app)
                        <tr>
                            <td>
                                <div class="table-dashboard-title">{{ $app->vacancy->title }}</div>
                                <div class="small table-dashboard-muted">{{ $app->vacancy->company }}</div>
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
                            @unless($self)
                                <td class="text-end">
                                    <a class="btn btn-kiu-neutral btn-kiu-sm" href="{{ route('applications.show', $app) }}">Open</a>
                                </td>
                            @endunless
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
