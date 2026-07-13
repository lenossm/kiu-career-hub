@auth
    @if(!request()->routeIs('home', 'login', 'register'))
        <nav class="kiu-mobile-nav">
            @if(auth()->user()->isAdmin())
                <a class="kiu-mobile-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="kiu-mobile-pill {{ request()->routeIs('vacancies.*') ? 'active' : '' }}" href="{{ route('vacancies.index') }}">Vacancies</a>
                <a class="kiu-mobile-pill {{ request()->routeIs('applications.*', 'professor-applications.*') ? 'active' : '' }}" href="{{ route('applications.index') }}">Apps</a>
            @elseif(auth()->user()->isStudent())
                <a class="kiu-mobile-pill {{ request()->routeIs('student.vacancies.*', 'student.feed', 'student.apply*') ? 'active' : '' }}" href="{{ route('student.vacancies.index') }}">Opportunities</a>
                <a class="kiu-mobile-pill {{ request()->routeIs('my.profile.*') ? 'active' : '' }}" href="{{ route('my.profile.show') }}">Profile</a>
            @elseif(auth()->user()->isProfessor())
                <a class="kiu-mobile-pill {{ request()->routeIs('professor.portal', 'professor.vacancies.*', 'professor.apply*') ? 'active' : '' }}" href="{{ route('professor.portal') }}">Opportunities</a>
                <a class="kiu-mobile-pill {{ request()->routeIs('professor.profile.*') ? 'active' : '' }}" href="{{ route('professor.profile.edit') }}">Profile</a>
            @endif
        </nav>
    @endif
@endauth
