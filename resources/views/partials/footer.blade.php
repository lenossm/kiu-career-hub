<footer class="py-4 mt-5" style="border-top:1px solid var(--line);color:var(--muted-2);background:rgba(4,11,20,.55)">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="small">
                <div class="fw-semibold text-white-75 mb-1" style="font-family:var(--display)">KIU Career Hub</div>
                <div>Career Office · Kutaisi International University</div>
            </div>
            <div class="kiu-footer-links d-flex flex-wrap gap-2 align-items-center">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                        <span>·</span>
                        <a href="{{ route('vacancies.index') }}">Vacancies</a>
                        <span>·</span>
                        <a href="{{ route('applications.index') }}">Applications</a>
                    @elseif(auth()->user()->isStudent())
                        <a class="{{ request()->routeIs('student.vacancies.*') ? 'active' : '' }}" href="{{ route('student.vacancies.index') }}">Opportunities</a>
                        <span>·</span>
                        <a href="{{ route('my.profile.show') }}">My profile</a>
                    @elseif(auth()->user()->isProfessor())
                        <a class="{{ request()->routeIs('professor.portal', 'professor.vacancies.*') ? 'active' : '' }}" href="{{ route('professor.portal') }}">Opportunities</a>
                        <span>·</span>
                        <a href="{{ route('professor.profile.edit') }}">My profile</a>
                    @endif
                @else
                    <a href="{{ route('login') }}">Sign in</a>
                    <span>·</span>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </div>
</footer>
