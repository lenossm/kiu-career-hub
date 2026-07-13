<nav class="navbar navbar-expand-lg kiu-nav">
    <div class="container py-2">
        <a class="kiu-brand" href="{{ auth()->check() ? auth()->user()->homeRoute() : route('home') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="KIU Career Hub" class="kiu-logo-nav">
            <span>KIU <strong>Career Hub</strong></span>
        </a>

        <button class="navbar-toggler btn-kiu-soft" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1 mt-3 mt-lg-0">
                @guest
                    <li class="nav-item"><a class="nav-link kiu-navlink" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link kiu-navlink" href="{{ route('login') }}">Sign in</a></li>
                    <li class="nav-item"><a class="btn btn-kiu" href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="nav-item d-none d-lg-block">
                        <span class="kiu-nav-user">
                            <span class="kiu-role-badge kiu-role-{{ auth()->user()->role }}">{{ ucfirst(auth()->user()->role) }}</span>
                            {{ auth()->user()->name }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button class="btn btn-kiu-ghost" type="submit"><i class="bi bi-box-arrow-right"></i> Log out</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
