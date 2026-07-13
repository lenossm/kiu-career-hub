@auth
<aside class="kiu-sidebar" aria-label="Navigation">
    <div class="kiu-sidebar-card">
        <div class="kiu-sidebar-user">
            <div class="kiu-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div style="min-width:0;">
                <div class="fw-semibold text-truncate">{{ auth()->user()->name }}</div>
                <span class="kiu-role-badge kiu-role-{{ auth()->user()->role }}">{{ ucfirst(auth()->user()->role) }}</span>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
            <nav class="d-flex flex-column gap-1">
                <a class="kiu-side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a class="kiu-side-link {{ request()->routeIs('vacancies.*') ? 'active' : '' }}" href="{{ route('vacancies.index') }}"><i class="bi bi-briefcase"></i> Vacancies</a>
                <a class="kiu-side-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}"><i class="bi bi-people"></i> Students</a>
                <a class="kiu-side-link {{ request()->routeIs('applications.*') ? 'active' : '' }}" href="{{ route('applications.index') }}"><i class="bi bi-inbox"></i> Applications</a>
                <a class="kiu-side-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}" href="{{ route('tasks.index') }}"><i class="bi bi-list-check"></i> Tasks</a>
            </nav>
        @elseif(auth()->user()->isStudent())
            <nav class="d-flex flex-column gap-1">
                <a class="kiu-side-link {{ request()->routeIs('student.vacancies.*', 'student.feed') ? 'active' : '' }}" href="{{ route('student.vacancies.index') }}"><i class="bi bi-briefcase"></i> Opportunities</a>
                <a class="kiu-side-link {{ request()->routeIs('my.profile.*') ? 'active' : '' }}" href="{{ route('my.profile.show') }}"><i class="bi bi-person-badge"></i> My profile</a>
            </nav>
        @elseif(auth()->user()->isProfessor())
            <nav class="d-flex flex-column gap-1">
                <a class="kiu-side-link {{ request()->routeIs('professor.portal') ? 'active' : '' }}" href="{{ route('professor.portal') }}"><i class="bi bi-building"></i> Faculty jobs</a>
                <a class="kiu-side-link {{ request()->routeIs('professor.profile.*') ? 'active' : '' }}" href="{{ route('professor.profile.edit') }}"><i class="bi bi-person-workspace"></i> My profile</a>
            </nav>
        @endif
    </div>
</aside>
@endauth
