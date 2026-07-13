@extends('layouts.app')

@section('title', 'Vacancies')

@section('content')
    <x-page-header
        title="Vacancy Management"
        subtitle="Browse, search, and manage career opportunities for KIU students. Pending = open · Done = closed."
        icon="bi-briefcase"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Vacancies', 'url' => route('vacancies.index')],
        ]"
    >
        <x-slot:actions>
            @if(auth()->user()->role === 'admin')
                <a class="btn btn-kiu" href="{{ route('vacancies.create') }}"><i class="bi bi-plus-circle me-1"></i> New vacancy</a>
            @endif
        </x-slot:actions>
        <x-slot:filters>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <a class="btn btn-kiu-ghost {{ $audience === '' ? 'active' : '' }}" href="{{ route('vacancies.index', array_filter(['q' => $q, 'status' => in_array($status, ['pending','done'], true) ? $status : null, 'type' => in_array($type ?? '', $allowedTypes ?? [], true) ? $type : null])) }}">All audiences</a>
                <a class="btn btn-kiu-ghost {{ $audience === 'student' ? 'active' : '' }}" href="{{ route('vacancies.index', array_filter(['audience' => 'student', 'q' => $q, 'status' => in_array($status, ['pending','done'], true) ? $status : null])) }}">Students</a>
                <a class="btn btn-kiu-ghost {{ $audience === 'professor' ? 'active' : '' }}" href="{{ route('vacancies.index', array_filter(['audience' => 'professor', 'q' => $q, 'status' => in_array($status, ['pending','done'], true) ? $status : null])) }}">Faculty</a>
                <a class="btn btn-kiu-ghost {{ $status === '' ? 'active' : '' }}" href="{{ route('vacancies.index', array_filter(['audience' => in_array($audience, ['student','professor'], true) ? $audience : null, 'q' => $q])) }}">All status</a>
                <a class="btn btn-kiu-ghost {{ $status === 'pending' ? 'active' : '' }}" href="{{ route('vacancies.index', array_filter(['status' => 'pending', 'q' => $q, 'type' => in_array($type ?? '', $allowedTypes ?? [], true) ? $type : null])) }}">Open</a>
                <a class="btn btn-kiu-ghost {{ $status === 'done' ? 'active' : '' }}" href="{{ route('vacancies.index', array_filter(['status' => 'done', 'q' => $q, 'type' => in_array($type ?? '', $allowedTypes ?? [], true) ? $type : null])) }}">Closed</a>

                <form class="d-flex gap-2 ms-lg-auto flex-grow-1 flex-lg-grow-0" method="GET" action="{{ route('vacancies.index') }}" style="min-width:260px;">
                    @if(in_array($status, ['pending', 'done'], true))
                        <input type="hidden" name="status" value="{{ $status }}">
                    @endif
                    @if(in_array($type ?? '', $allowedTypes ?? [], true))
                        <input type="hidden" name="type" value="{{ $type }}">
                    @endif
                    <div class="input-group kiu-input-group flex-grow-1">
                        <span class="input-group-text bg-transparent border-0 text-white-65"><i class="bi bi-search"></i></span>
                        <input class="form-control" name="q" value="{{ $q }}" placeholder="Search title, company, skills...">
                    </div>
                    <button class="btn btn-kiu-soft" type="submit">Go</button>
                </form>

                <form method="GET" action="{{ route('vacancies.index') }}">
                    @if(in_array($status, ['pending', 'done'], true))
                        <input type="hidden" name="status" value="{{ $status }}">
                    @endif
                    @if($q !== '')
                        <input type="hidden" name="q" value="{{ $q }}">
                    @endif
                    <select class="form-select" name="type" onchange="this.form.submit()" style="width:170px;">
                        <option value="">All types</option>
                        @foreach(($allowedTypes ?? []) as $t)
                            <option value="{{ $t }}" @selected(($type ?? '') === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            @if($vacancies->count() > 0)
                <div class="small text-white-65 mt-2 mb-0">
                    @if($q !== '') Results for “{{ $q }}” · @endif
                    {{ $vacancies->total() }} {{ $vacancies->total() === 1 ? 'vacancy' : 'vacancies' }}
                </div>
            @endif
        </x-slot:filters>
    </x-page-header>

    <div class="row g-3">
        @forelse($vacancies as $vacancy)
            <div class="col-12 col-lg-6 anim-fade-up">
                <div class="kiu-card kiu-lift h-100" data-vacancy-id="{{ $vacancy->id }}">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <x-status-badge :status="$vacancy->status === 'done' ? 'done' : 'pending'" />
                            <span class="kiu-badge"><i class="bi bi-tag"></i> {{ $vacancy->type }}</span>
                            <span class="kiu-badge {{ $vacancy->audience === 'professor' ? 'kiu-badge-professor' : '' }}">
                                <i class="bi {{ $vacancy->audience === 'professor' ? 'bi-building' : 'bi-mortarboard' }}"></i>
                                {{ $vacancy->audience === 'professor' ? 'Faculty' : 'Students' }}
                            </span>
                            <span class="kiu-badge"><i class="bi bi-geo-alt"></i> {{ $vacancy->location }}</span>
                        </div>
                        <h2 class="h5 fw-bold mb-1">
                            <a class="text-decoration-none vacancy-card-title" href="{{ route('vacancies.show', $vacancy) }}">{{ $vacancy->title }}</a>
                        </h2>
                        <div class="small text-white-75 mb-2"><i class="bi bi-building me-1"></i>{{ $vacancy->company }}</div>
                        <div class="small text-white-65 mb-2"><i class="bi bi-calendar2-week me-1"></i>Deadline {{ $vacancy->deadline->format('M j, Y') }}</div>
                        <p class="text-white-75 small mb-2 kiu-clamp-2">{{ $vacancy->description }}</p>
                        <div class="small text-white-65">Skills: <span class="text-white-75">{{ $vacancy->required_skills }}</span></div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4 px-4 pt-0">
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-kiu btn-kiu-sm" href="{{ route('vacancies.show', $vacancy) }}"><i class="bi bi-eye me-1"></i> View</a>
                            <a class="btn btn-kiu-soft btn-kiu-sm" href="{{ route('vacancies.apply', $vacancy) }}"><i class="bi bi-send me-1"></i> Apply</a>
                            @if(auth()->user()->role === 'admin')
                                <form method="POST" action="{{ route('vacancies.toggleStatus', $vacancy) }}" class="js-toggle-status">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-kiu-status-toggle btn-kiu-sm" type="submit" data-role="toggle-button">
                                        {{ $vacancy->status === 'done' ? 'Reopen' : 'Close' }}
                                    </button>
                                </form>
                                <a class="btn btn-kiu-neutral btn-kiu-sm" href="{{ route('vacancies.edit', $vacancy) }}"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('vacancies.destroy', $vacancy) }}" onsubmit="return confirm('Delete this vacancy?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-kiu-danger-outline btn-kiu-sm" type="submit"><i class="bi bi-trash"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="kiu-card">
                    <x-empty-state icon="bi-briefcase" title="No vacancies found" description="Try clearing filters or create a new opportunity.">
                        <x-slot:action>
                            @if(auth()->user()->role === 'admin')
                                <a class="btn btn-kiu" href="{{ route('vacancies.create') }}"><i class="bi bi-plus-circle me-1"></i> Add vacancy</a>
                            @endif
                        </x-slot:action>
                    </x-empty-state>
                </div>
            </div>
        @endforelse
    </div>

    <x-pagination-info :paginator="$vacancies" class="mt-3" />
@endsection
