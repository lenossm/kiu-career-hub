@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="kiu-welcome-banner anim-fade-up">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <div class="small text-white-65 text-uppercase mb-1" style="letter-spacing:.06em;">Career office</div>
                <h1 class="h3 fw-bold mb-1 kiu-title">Hello, {{ auth()->user()->name }}</h1>
                <p class="kiu-meta mb-0">Manage student & faculty vacancies, review applications, and track office tasks — all in one place.</p>
            </div>
            <span class="kiu-role-badge kiu-role-admin">
                <i class="bi bi-shield-check"></i> Administrator
            </span>
        </div>
    </div>

    <div class="kiu-quick-actions anim-fade-up">
        <a class="kiu-quick-action kiu-quick-action-primary" href="{{ route('vacancies.create', ['audience' => 'student']) }}">
            <i class="bi bi-mortarboard"></i> Post student vacancy
        </a>
        <a class="kiu-quick-action" href="{{ route('vacancies.create', ['audience' => 'professor']) }}">
            <i class="bi bi-person-workspace"></i> Post faculty vacancy
        </a>
        <a class="kiu-quick-action" href="{{ route('applications.index') }}">
            <i class="bi bi-inbox"></i> Review applications
        </a>
        <a class="kiu-quick-action" href="{{ route('students.index') }}">
            <i class="bi bi-people"></i> Student profiles
        </a>
        <a class="kiu-quick-action" href="{{ route('tasks.create') }}">
            <i class="bi bi-clipboard-plus"></i> Add task
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <x-stat-card label="Open — students" :value="$stats['vacancies_student']" icon="bi-mortarboard" href="{{ route('vacancies.index', ['audience' => 'student', 'status' => 'pending']) }}" accent="blue" />
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <x-stat-card label="Open — faculty" :value="$stats['vacancies_faculty']" icon="bi-building" href="{{ route('vacancies.index', ['audience' => 'professor', 'status' => 'pending']) }}" accent="purple" class="anim-delay-1" />
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <x-stat-card label="Applications" :value="$stats['applications_total']" icon="bi-send-check" href="{{ route('applications.index') }}" :hint="$stats['applications_pending'].' pending'" accent="green" class="anim-delay-2" />
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <x-stat-card label="Student profiles" :value="$stats['students_total']" icon="bi-people" href="{{ route('students.index') }}" accent="amber" class="anim-delay-3" />
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-xl-7">
            <div class="kiu-section-card anim-fade-up">
                <div class="kiu-section-card-header">
                    <div class="fw-bold"><i class="bi bi-briefcase me-2"></i>Recent vacancies</div>
                    <a class="btn btn-kiu-soft btn-kiu-sm" href="{{ route('vacancies.index') }}">View all</a>
                </div>
                <div class="kiu-section-card-body">
                    <div class="table-responsive">
                        <table class="table table-dashboard align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Audience</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th class="text-end"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($recentVacancies as $v)
                                <tr>
                                    <td>
                                        <div class="table-dashboard-title">{{ $v->title }}</div>
                                        <div class="small table-dashboard-muted">{{ $v->company }}</div>
                                    </td>
                                    <td>
                                        <span class="kiu-badge {{ $v->audience === 'professor' ? 'kiu-badge-professor' : '' }}">
                                            {{ $v->audience === 'professor' ? 'Faculty' : 'Students' }}
                                        </span>
                                    </td>
                                    <td class="table-dashboard-cell">{{ $v->deadline->format('M j, Y') }}</td>
                                    <td><x-status-badge :status="$v->status === 'done' ? 'done' : 'pending'" /></td>
                                    <td class="text-end">
                                        <a class="btn btn-kiu-neutral btn-kiu-sm" href="{{ route('vacancies.show', $v) }}">Open</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-white-75">No vacancies yet. <a href="{{ route('vacancies.create') }}">Post one</a>.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <div class="kiu-section-card anim-fade-up anim-delay-1 mb-3">
                <div class="kiu-section-card-header">
                    <div class="fw-bold"><i class="bi bi-mortarboard me-2"></i>Student applications</div>
                    <a class="btn btn-kiu-soft btn-kiu-sm" href="{{ route('applications.index') }}">All</a>
                </div>
                <div class="kiu-section-card-body kiu-section-card-body--pad">
                    @forelse($recentApplications as $app)
                        <div class="d-flex justify-content-between align-items-center gap-2 py-3 kiu-list-row">
                            <div style="min-width:0;">
                                <div class="fw-semibold text-truncate">{{ $app->student->full_name }}</div>
                                <div class="small table-dashboard-muted text-truncate">{{ $app->vacancy->title }}</div>
                            </div>
                            <x-status-badge :status="$app->status" />
                        </div>
                    @empty
                        <div class="kiu-empty-inline">No student applications yet.</div>
                    @endforelse
                </div>
            </div>

            <div class="kiu-section-card anim-fade-up anim-delay-2">
                <div class="kiu-section-card-header">
                    <div class="fw-bold"><i class="bi bi-person-workspace me-2"></i>Faculty applications</div>
                    <a class="btn btn-kiu-soft btn-kiu-sm" href="{{ route('applications.index', ['tab' => 'faculty']) }}">All</a>
                </div>
                <div class="kiu-section-card-body kiu-section-card-body--pad">
                    @forelse($recentFacultyApplications as $app)
                        <div class="d-flex justify-content-between align-items-center gap-2 py-3 kiu-list-row">
                            <div style="min-width:0;">
                                <div class="fw-semibold text-truncate">{{ $app->professor->full_name }}</div>
                                <div class="small table-dashboard-muted text-truncate">{{ $app->vacancy->title }}</div>
                            </div>
                            <x-status-badge :status="$app->status" />
                        </div>
                    @empty
                        <div class="kiu-empty-inline">No faculty applications yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
