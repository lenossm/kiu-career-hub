@extends('layouts.landing')

@section('title', 'KIU Career Hub')

@section('content')
    <section class="hero">
        <div class="container position-relative">
            <div class="row align-items-center g-4">
                <div class="col-12 col-lg-6">
                    <div class="kicker mb-3">
                        <i class="bi bi-building"></i>
                        <span>Career Hub</span>
                    </div>

                    <h1 class="headline display-5 mb-3">
                        Opportunities and talent, connected.
                    </h1>

                    <p class="subhead mb-4">
                        KIU Career Hub organizes vacancies and student-ready opportunities in one place,
                        with clear deadlines and status tracking for HR teams and university staff.
                    </p>

                    <div class="slogan mb-4">
                        Place where knowledge creates future!
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-kiu btn-lg" href="{{ route('vacancies.index') }}">
                            <i class="bi bi-briefcase me-2"></i> Find a job / opportunity
                        </a>
                        <a class="btn btn-outline-kiu btn-lg" href="{{ route('vacancies.create') }}">
                            <i class="bi bi-megaphone me-2"></i> Post an opportunity
                        </a>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <span class="kicker"><i class="bi bi-people"></i> HR-ready workflow</span>
                        <span class="kicker"><i class="bi bi-shield-check"></i> Centralized posting</span>
                        <span class="kicker"><i class="bi bi-calendar2-week"></i> Deadline visibility</span>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="text-center">
                        <img class="hero-logo" src="{{ asset('images/kiu-logo.png') }}" alt="Kutaisi International University">
                    </div>
                </div>
            </div>

            <div class="wave" aria-hidden="true"></div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            <div class="row g-3">
                <div class="col-12 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="d-flex gap-3 align-items-start position-relative">
                            <div class="icon-pill"><i class="bi bi-kanban"></i></div>
                            <div>
                                <div class="fw-bold mb-1">For HR and staff</div>
                                <div class="text-secondary">Post vacancies and manage them with clear status and deadlines.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="d-flex gap-3 align-items-start position-relative">
                            <div class="icon-pill"><i class="bi bi-funnel"></i></div>
                            <div>
                                <div class="fw-bold mb-1">Faster access to talent</div>
                                <div class="text-secondary">Filter open roles, search by keywords, and keep everything organized.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="feature-card p-4 h-100">
                        <div class="d-flex gap-3 align-items-start position-relative">
                            <div class="icon-pill"><i class="bi bi-calendar2-week"></i></div>
                            <div>
                                <div class="fw-bold mb-1">Clarity for students</div>
                                <div class="text-secondary">Students can browse opportunities and see deadlines at a glance.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a class="btn btn-kiu btn-lg" href="{{ route('vacancies.index') }}">
                    <i class="bi bi-arrow-right-circle me-2"></i> Enter the Opportunities Board
                </a>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            <div class="feature-card p-4 p-lg-5">
                <div class="row g-4 align-items-start position-relative">
                    <div class="col-12 col-lg-5">
                        <div class="kicker mb-3"><i class="bi bi-info-circle"></i> About this page</div>
                        <div class="fw-bold fs-3 mb-2">A simple system with a clear purpose</div>
                        <div class="text-secondary">
                            KIU Career Hub centralizes vacancies and student-ready opportunities so they are easy to publish,
                            easy to find, and easy to keep up to date.
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="feature-card p-4 h-100">
                                    <div class="d-flex gap-3 align-items-start position-relative">
                                        <div class="icon-pill"><i class="bi bi-person-badge"></i></div>
                                        <div>
                                            <div class="fw-bold mb-1">Why it helps HR</div>
                                            <div class="text-secondary">
                                                A single board to post roles, manage deadlines, and close filled positions—so HR can focus on selecting the best candidates.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="feature-card p-4 h-100">
                                    <div class="d-flex gap-3 align-items-start position-relative">
                                        <div class="icon-pill"><i class="bi bi-mortarboard"></i></div>
                                        <div>
                                            <div class="fw-bold mb-1">Why it helps students</div>
                                            <div class="text-secondary">
                                                Students can quickly browse current opportunities, search by keywords, and see deadlines without missing important updates.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-secondary mt-3">
                            Admin actions (posting, editing, status changes) are protected with login, while browsing can remain public.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

