@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="row justify-content-center py-3">
        <div class="col-12 col-lg-8 kiu-auth-card">
            <div class="text-center mb-4 anim-fade-up">
                <img src="{{ asset('images/logo.svg') }}" alt="KIU" class="kiu-logo-auth mb-3">
                <h1 class="h3 fw-bold mb-1">Create your account</h1>
                <p class="text-muted-soft mb-0">Pick the role that matches how you'll use Career Hub</p>
            </div>

            <div class="kiu-card p-4 anim-fade-up">
                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <label class="form-label fw-semibold mb-2">Account type</label>
                    <div class="row g-3 mb-4">
                        @foreach($roles as [$value, $icon, $label, $hint])
                            <div class="col-md-{{ count($roles) === 2 ? '6' : '4' }}">
                                <label class="kiu-role-card {{ old('role', 'student') === $value ? 'active' : '' }}">
                                    <input type="radio" name="role" value="{{ $value }}" class="d-none" {{ old('role', 'student') === $value ? 'checked' : '' }} required>
                                    <i class="bi {{ $icon }} kiu-role-icon"></i>
                                    <div class="fw-bold">{{ $label }}</div>
                                    <div class="small text-muted-soft">{{ $hint }}</div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('role')<div class="text-danger small mb-3">{{ $message }}</div>@enderror

                    <x-form-input name="name" label="Full name" :value="old('name')" required />
                    <x-form-input name="email" label="Email" type="email" :value="old('email')" required />
                    <x-form-input name="password" label="Password" type="password" required />
                    <x-form-input name="password_confirmation" label="Confirm password" type="password" required />

                    <button class="btn btn-kiu w-100" type="submit">Create account</button>
                </form>

                <div class="text-center mt-3 small text-muted-soft">
                    Already have an account? <a href="{{ route('login') }}">Sign in</a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.querySelectorAll('.kiu-role-card input').forEach((input) => {
            input.addEventListener('change', () => {
                document.querySelectorAll('.kiu-role-card').forEach((c) => c.classList.remove('active'));
                input.closest('.kiu-role-card')?.classList.add('active');
            });
        });
    </script>
    @endpush
@endsection
