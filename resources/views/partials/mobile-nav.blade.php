@auth
    @if(!request()->routeIs('home', 'login', 'register'))
        <nav class="kiu-mobile-nav">
            @if(auth()->user()->isAdmin())
                <a class="kiu-mobile-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="kiu-mobile-pill" href="{{ route('vacancies.index') }}">Vacancies</a>
                <a class="kiu-mobile-pill" href="{{ route('applications.index') }}">Apps</a>
            @elseif(auth()->user()->isStudent())
                <a class="kiu-mobile-pill {{ request()->routeIs('student.vacancies.*', 'student.feed') ? 'active' : '' }}" href="{{ route('student.vacancies.index') }}">Jobs</a>
                <a class="kiu-mobile-pill" href="{{ route('my.profile.show') }}">Profile</a>
            @elseif(auth()->user()->isProfessor())
                <a class="kiu-mobile-pill {{ request()->routeIs('professor.portal') ? 'active' : '' }}" href="{{ route('professor.portal') }}">Jobs</a>
                <a class="kiu-mobile-pill" href="{{ route('professor.profile.edit') }}">Profile</a>
            @endif
        </nav>
    @endif
@endauth
