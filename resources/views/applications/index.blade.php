@extends('layouts.app')

@section('title', 'Applications')

@section('content')
    @php $activeTab = request('tab', 'students'); @endphp

    <x-page-header
        title="Applications"
        subtitle="Review student and faculty applications — cover letters, resumes, and status updates."
        icon="bi-send-check"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Applications', 'url' => route('applications.index')],
        ]"
    >
        <x-slot:actions>
            <a class="btn btn-kiu-soft" href="{{ route('vacancies.index') }}"><i class="bi bi-briefcase me-1"></i> Vacancies</a>
        </x-slot:actions>
    </x-page-header>

    <ul class="nav nav-pills kiu-tab-pills mb-3 anim-fade-up" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $activeTab === 'students' ? 'active' : '' }}" href="{{ route('applications.index', ['tab' => 'students']) }}">
                <i class="bi bi-mortarboard me-1"></i> Student applications
                <span class="badge rounded-pill ms-1">{{ $applications->total() }}</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $activeTab === 'faculty' ? 'active' : '' }}" href="{{ route('applications.index', ['tab' => 'faculty']) }}">
                <i class="bi bi-person-workspace me-1"></i> Faculty applications
                <span class="badge rounded-pill ms-1">{{ $professorApplications->total() }}</span>
            </a>
        </li>
    </ul>

    @if($activeTab === 'faculty')
        <div class="kiu-section-card anim-fade-up">
            <div class="table-responsive">
                <table class="table table-dashboard align-middle mb-0">
                    <thead>
                    <tr>
                        <th>Professor / TA</th>
                        <th>Vacancy</th>
                        <th>Department</th>
                        <th>Resume</th>
                        <th>Status</th>
                        <th class="text-end">Submitted</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($professorApplications as $app)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $app->professor->full_name }}</div>
                                <div class="small table-dashboard-muted">{{ $app->professor->department }}</div>
                            </td>
                            <td>
                                <a class="text-decoration-none table-dashboard-link" href="{{ route('vacancies.show', $app->vacancy) }}">{{ $app->vacancy->title }}</a>
                            </td>
                            <td class="table-dashboard-cell">{{ $app->vacancy->company }}</td>
                            <td>
                                @if($app->resume_path)
                                    <span class="kiu-file-pill"><i class="bi bi-file-earmark-pdf"></i> Attached</span>
                                @else
                                    <span class="kiu-file-pill missing"><i class="bi bi-dash"></i> None</span>
                                @endif
                            </td>
                            <td><x-status-badge :status="$app->status" /></td>
                            <td class="text-end table-dashboard-cell">{{ $app->created_at->format('M j, Y') }}</td>
                            <td class="text-end">
                                <a class="btn btn-kiu-neutral btn-kiu-sm" href="{{ route('professor-applications.show', $app) }}"><i class="bi bi-eye"></i></a>
                                <a class="btn btn-kiu-soft btn-kiu-sm" href="{{ route('professor-applications.edit', $app) }}"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-0">
                                <x-empty-state icon="bi-inbox" title="No faculty applications yet" description="Applications appear here when professors apply to internal KIU positions." />
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($professorApplications->count() > 0)
                <div class="p-3 border-top" style="border-color:var(--border)!important;">
                    <x-pagination-info :paginator="$professorApplications" />
                </div>
            @endif
        </div>
    @else
        <div class="kiu-section-card anim-fade-up">
            <div class="table-responsive">
                <table class="table table-dashboard align-middle mb-0">
                    <thead>
                    <tr>
                        <th>Student</th>
                        <th>Vacancy</th>
                        <th>Company</th>
                        <th>Resume</th>
                        <th>Status</th>
                        <th class="text-end">Submitted</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($applications as $app)
                        <tr>
                            <td>
                                <a class="text-decoration-none table-dashboard-link fw-semibold" href="{{ route('students.show', $app->student) }}">{{ $app->student->full_name }}</a>
                                <div class="small table-dashboard-muted">{{ $app->student->faculty }}</div>
                            </td>
                            <td>
                                <a class="text-decoration-none table-dashboard-link" href="{{ route('vacancies.show', $app->vacancy) }}">{{ $app->vacancy->title }}</a>
                            </td>
                            <td class="table-dashboard-cell">{{ $app->vacancy->company }}</td>
                            <td>
                                @if($app->resume_path)
                                    <span class="kiu-file-pill"><i class="bi bi-file-earmark-pdf"></i> Attached</span>
                                @else
                                    <span class="kiu-file-pill missing"><i class="bi bi-dash"></i> None</span>
                                @endif
                            </td>
                            <td><x-status-badge :status="$app->status" /></td>
                            <td class="text-end table-dashboard-cell">{{ $app->created_at->format('M j, Y') }}</td>
                            <td class="text-end">
                                <a class="btn btn-kiu-neutral btn-kiu-sm" href="{{ route('applications.show', $app) }}"><i class="bi bi-eye"></i></a>
                                <a class="btn btn-kiu-soft btn-kiu-sm" href="{{ route('applications.edit', $app) }}"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-0">
                                <x-empty-state icon="bi-inbox" title="No student applications yet" description="Applications appear here when students apply to vacancies from their personalized feed.">
                                    <x-slot:action>
                                        <a class="btn btn-kiu" href="{{ route('vacancies.index') }}"><i class="bi bi-briefcase me-1"></i> Go to vacancies</a>
                                    </x-slot:action>
                                </x-empty-state>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($applications->count() > 0)
                <div class="p-3 border-top" style="border-color:var(--border)!important;">
                    <x-pagination-info :paginator="$applications" />
                </div>
            @endif
        </div>
    @endif
@endsection
