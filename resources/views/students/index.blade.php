@extends('layouts.app')

@section('title', 'Students')

@section('content')
    <x-page-header
        title="Student Profiles"
        subtitle="Browse registered student profiles, skills, and application activity across the KIU career platform."
        icon="bi-people"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Students', 'url' => route('students.index')],
        ]"
    >
        <x-slot:filters>
            <form class="d-flex flex-wrap gap-2" method="GET" action="{{ route('students.index') }}">
                <div class="input-group kiu-input-group flex-grow-1" style="min-width:220px;max-width:420px;">
                    <span class="input-group-text bg-transparent border-0 text-white-65"><i class="bi bi-search"></i></span>
                    <input class="form-control" name="q" value="{{ $q }}" placeholder="Search name, faculty, or skills...">
                </div>
                <button class="btn btn-kiu-soft" type="submit">Search</button>
                @if($q !== '')
                    <a class="btn btn-kiu-ghost" href="{{ route('students.index') }}">Clear</a>
                @endif
            </form>
        </x-slot:filters>
    </x-page-header>

    <div class="row g-3">
        @forelse($students as $student)
            @php
                $initials = collect(preg_split('/\s+/', trim($student->full_name)))->filter()->take(2)->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->join('');
                $skillPreview = collect(explode(',', $student->skills))->map(fn ($s) => trim($s))->filter()->take(4);
            @endphp
            <div class="col-12 col-lg-6 anim-fade-up">
                <div class="kiu-card kiu-lift h-100">
                    <div class="card-body p-4">
                        <div class="kiu-student-card-top">
                            @if($student->photo_path)
                                <img src="{{ asset('storage/'.$student->photo_path) }}" alt="{{ $student->full_name }}" class="kiu-student-photo">
                            @else
                                <div class="kiu-avatar kiu-student-photo" style="border-radius:16px;">{{ $initials }}</div>
                            @endif
                            <div style="min-width:0;flex:1;">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div style="min-width:0;">
                                        <div class="fw-bold fs-5 text-truncate">{{ $student->full_name }}</div>
                                        <div class="small text-white-75"><i class="bi bi-mortarboard me-1"></i>{{ $student->faculty }}</div>
                                    </div>
                                    <span class="kiu-badge"><i class="bi bi-file-earmark-person"></i> {{ $student->applications_count }} apps</span>
                                </div>
                                <p class="text-white-75 small mt-2 mb-2 kiu-clamp-2">{{ $student->short_bio }}</p>
                                <div>
                                    @foreach($skillPreview as $skill)
                                        <span class="kiu-skill-chip">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-0 pb-4 px-4">
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-kiu btn-kiu-sm" href="{{ route('students.show', $student) }}"><i class="bi bi-eye me-1"></i> View profile</a>
                            <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete this profile?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-kiu-danger-outline btn-kiu-sm" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="kiu-card">
                    <x-empty-state
                        icon="bi-people"
                        title="No student profiles yet"
                        description="{{ $q ? 'No results for your search. Try different keywords.' : 'Students create their own profiles after registering with a student account.' }}"
                    />
                </div>
            </div>
        @endforelse
    </div>

    <x-pagination-info :paginator="$students" class="mt-3" />
@endsection
