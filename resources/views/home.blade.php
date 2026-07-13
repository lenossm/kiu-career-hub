@extends('layouts.app')

@section('title', 'Home')
@section('body_class', 'page-home')

@section('content')
    <section class="kiu-hero-main mb-5 anim-fade-in">
        <div class="row align-items-end g-4">
            <div class="col-12 col-lg-8">
                <div class="kiu-hero-badge mb-3 anim-fade-up">
                    <img src="{{ asset('images/logo.svg') }}" alt="" class="kiu-logo-hero">
                    <span>Kutaisi International University</span>
                </div>

                <h1 class="kiu-hero-title anim-fade-up anim-delay-1">
                    <span class="d-block">KIU Career Hub</span>
                    <span class="text-gold">Work that fits your path.</span>
                </h1>

                <p class="kiu-hero-lead mt-3 mb-4 anim-fade-up anim-delay-2">
                    Internships for students. Internal roles for faculty. One office to run it all.
                </p>

                <div class="d-flex flex-wrap gap-2 anim-fade-up anim-delay-3">
                    @auth
                        <a class="btn btn-kiu btn-lg" href="{{ auth()->user()->homeRoute() }}">Open my account</a>
                    @else
                        <a class="btn btn-kiu btn-lg" href="{{ route('login') }}">Sign in</a>
                        <a class="btn btn-kiu-soft btn-lg" href="{{ route('register') }}">Create account</a>
                    @endauth
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="kiu-stat-card kiu-stat-blue kiu-tilt anim-pop">
                            <div class="kiu-stat-icon"><i class="bi bi-briefcase"></i></div>
                            <div class="kiu-stat-label">Student jobs</div>
                            <div class="kiu-stat-value">{{ $stats['student_vacancies'] ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="kiu-stat-card kiu-stat-green kiu-tilt anim-pop anim-delay-1">
                            <div class="kiu-stat-icon"><i class="bi bi-building"></i></div>
                            <div class="kiu-stat-label">Faculty roles</div>
                            <div class="kiu-stat-value">{{ $stats['professor_vacancies'] ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="kiu-stat-card kiu-stat-amber kiu-tilt anim-pop anim-delay-2">
                            <div class="kiu-stat-icon"><i class="bi bi-people"></i></div>
                            <div class="kiu-stat-label">Profiles</div>
                            <div class="kiu-stat-value">{{ $students_total ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="kiu-stat-card kiu-stat-slate kiu-tilt anim-pop anim-delay-3">
                            <div class="kiu-stat-icon"><i class="bi bi-send-check"></i></div>
                            <div class="kiu-stat-label">Applications</div>
                            <div class="kiu-stat-value">{{ $stats['applications_total'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-5">
        <div class="d-flex align-items-end justify-content-between gap-3 mb-3">
            <div>
                <div class="kiu-eyebrow mb-1">Simple flow</div>
                <h2 class="h3 mb-0 anim-fade-up">How people use it</h2>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-md-4 anim-fade-up">
                <div class="kiu-step-card">
                    <div class="kiu-step-num">1</div>
                    <div class="fw-bold mb-1">Set up your profile</div>
                    <p class="small text-muted-soft mb-0">Students add skills. Faculty add department info. Takes a few minutes.</p>
                </div>
            </div>
            <div class="col-md-4 anim-fade-up anim-delay-1">
                <div class="kiu-step-card">
                    <div class="kiu-step-num">2</div>
                    <div class="fw-bold mb-1">Browse your openings</div>
                    <p class="small text-muted-soft mb-0">You only see vacancies posted for your role — nothing mixed up.</p>
                </div>
            </div>
            <div class="col-md-4 anim-fade-up anim-delay-2">
                <div class="kiu-step-card">
                    <div class="kiu-step-num">3</div>
                    <div class="fw-bold mb-1">Apply and track</div>
                    <p class="small text-muted-soft mb-0">Send a cover letter and CV. Career office reviews everything in one place.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div class="kiu-eyebrow mb-1">Built for campus</div>
        <h2 class="h3 mb-3 anim-fade-up">Three sides, one product</h2>
        <div class="row g-3">
            <div class="col-md-4 anim-fade-up">
                <div class="kiu-role-card kiu-feature-role kiu-role-student h-100">
                    <div class="kiu-role-card-icon"><i class="bi bi-mortarboard"></i></div>
                    <h3 class="h5 fw-bold">Students</h3>
                    <p class="text-muted-soft small mb-0">Profile, vacancy list with skill match hints, online applications.</p>
                </div>
            </div>
            <div class="col-md-4 anim-fade-up anim-delay-1">
                <div class="kiu-role-card kiu-feature-role kiu-role-professor h-100">
                    <div class="kiu-role-card-icon"><i class="bi bi-person-workspace"></i></div>
                    <h3 class="h5 fw-bold">Professors & TAs</h3>
                    <p class="text-muted-soft small mb-0">Internal KIU roles only — TA posts, research leads, campus jobs.</p>
                </div>
            </div>
            <div class="col-md-4 anim-fade-up anim-delay-2">
                <div class="kiu-role-card kiu-feature-role kiu-role-admin h-100">
                    <div class="kiu-role-card-icon"><i class="bi bi-shield-check"></i></div>
                    <h3 class="h5 fw-bold">Career office</h3>
                    <p class="text-muted-soft small mb-0">Post by audience, review applications, keep office tasks moving.</p>
                </div>
            </div>
        </div>
    </section>

    @if(!empty($featuredVacancy))
        <div class="kiu-card p-4 anim-fade-up kiu-featured-vacancy">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <div class="kiu-eyebrow mb-1">Recently posted</div>
                    <div class="fw-bold fs-5">{{ $featuredVacancy->title }}</div>
                    <div class="text-muted-soft">{{ $featuredVacancy->company }} · Deadline {{ $featuredVacancy->deadline->format('M j, Y') }}</div>
                </div>
                @guest
                    <a class="btn btn-kiu" href="{{ route('login') }}">Sign in to apply</a>
                @else
                    @if(auth()->user()->isStudent())
                        <a class="btn btn-kiu" href="{{ route('student.vacancies.index') }}">See opportunities</a>
                    @endif
                @endguest
            </div>
        </div>
    @endif
@endsection
