@extends('layouts.app')

@section('title', 'Sign in')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9 col-xl-8">
            <div class="text-center mb-4 anim-fade-up">
                <img src="{{ asset('images/logo.svg') }}" alt="KIU Career Hub" class="kiu-logo-auth mb-3">
                <h1 class="h2 fw-bold mb-1">Sign in</h1>
                <p class="text-muted-soft mb-0">Pick a campus role or use your email</p>
            </div>

            @if($demoLoginsEnabled)
                <div class="row g-3 mb-4">
                    @foreach([
                        ['student', 'bi-mortarboard', 'Student', 'Jobs & applications'],
                        ['professor', 'bi-person-workspace', 'Faculty', 'Internal KIU roles'],
                        ['admin', 'bi-shield-check', 'Career office', 'Vacancies & reviews'],
                    ] as $i => [$role, $icon, $label, $hint])
                        <div class="col-12 col-md-4 anim-fade-up anim-delay-{{ $i }}">
                            <form method="POST" action="{{ route('demo.login', $role) }}" class="h-100">
                                @csrf
                                <button type="submit" class="kiu-demo-login-card kiu-role-{{ $role }} w-100 h-100">
                                    <span class="kiu-demo-login-icon"><i class="bi {{ $icon }}"></i></span>
                                    <span class="kiu-demo-login-label">{{ $label }}</span>
                                    <span class="kiu-demo-login-hint">{{ $hint }}</span>
                                    <span class="kiu-demo-login-cta">Continue <i class="bi bi-arrow-right-short"></i></span>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="kiu-card p-4 p-lg-4 anim-fade-up">
                <div class="fw-semibold mb-3"><i class="bi bi-envelope me-1"></i> Email</div>
                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <x-form-input name="email" label="Email" type="email" :value="old('email')" required />
                        </div>
                        <div class="col-md-6">
                            <x-form-input name="password" label="Password" type="password" required />
                        </div>
                    </div>
                    <button class="btn btn-kiu w-100 mt-2" type="submit">Sign in</button>
                </form>
                <div class="text-center mt-3 small text-muted-soft">
                    No account yet? <a href="{{ route('register') }}">Register</a>
                </div>
            </div>
        </div>
    </div>
@endsection
