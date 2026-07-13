<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register', [
            'roles' => $this->registrationRoles(),
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in($this->allowedRegistrationRoles())],
        ]);

        $user = User::create($validated);

        Auth::login($user);
        $request->session()->regenerate();

        $message = match ($user->role) {
            User::ROLE_STUDENT => 'Welcome. Complete your profile to browse and apply for student opportunities.',
            User::ROLE_PROFESSOR => 'Welcome. Set up your faculty profile to view internal positions.',
            default => 'Welcome to the KIU Career Office panel.',
        };

        return redirect($this->onboardingRoute($user))->with('success', $message);
    }

    public function showLogin()
    {
        return view('auth.login', [
            'demoLoginsEnabled' => config('kiu.demo_logins_enabled'),
        ]);
    }

    /**
     * Seeded test accounts — handy for demos and local dev.
     * Disabled via DEMO_LOGINS_ENABLED when you don't want one-click access.
     */
    public function demoLogin(Request $request, string $role)
    {
        if (! config('kiu.demo_logins_enabled')) {
            abort(404);
        }

        $accounts = [
            User::ROLE_ADMIN => 'admin@kiu.test',
            User::ROLE_STUDENT => 'student@kiu.test',
            User::ROLE_PROFESSOR => 'professor@kiu.test',
        ];

        if (! isset($accounts[$role])) {
            abort(404);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user = User::query()->where('email', $accounts[$role])->first();

        if (! $user) {
            return redirect()
                ->route('login')
                ->with('error', 'This account is not available. Please contact the career office.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect($this->onboardingRoute($user))
            ->with('success', 'Signed in successfully.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials['email'] = strtolower(trim($credentials['email']));
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Invalid email or password.']);
        }

        $request->session()->regenerate();

        /** @var User $user */
        $user = Auth::user();

        return redirect($this->onboardingRoute($user))->with('success', 'Signed in successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Signed out.');
    }

    /** Send new users to profile setup first if they haven't filled it in yet */
    private function onboardingRoute(User $user): string
    {
        session()->forget('url.intended');

        if ($user->isStudent() && ! $user->student) {
            return route('my.profile.create');
        }

        if ($user->isProfessor() && ! $user->professor) {
            return route('professor.profile.create');
        }

        return $user->homeRoute();
    }

    private function allowedRegistrationRoles(): array
    {
        $roles = [User::ROLE_STUDENT, User::ROLE_PROFESSOR];

        if (config('kiu.allow_admin_register')) {
            $roles[] = User::ROLE_ADMIN;
        }

        return $roles;
    }

    private function registrationRoles(): array
    {
        $all = [
            ['student', 'bi-mortarboard', 'Student', 'Browse opportunities and apply to student positions'],
            ['professor', 'bi-person-workspace', 'Professor / TA', 'Apply to internal faculty positions at KIU'],
            ['admin', 'bi-shield-check', 'Career Office', 'Manage vacancies, applications, and office tasks'],
        ];

        if (config('kiu.allow_admin_register')) {
            return $all;
        }

        return array_values(array_filter($all, fn (array $role) => $role[0] !== 'admin'));
    }
}
