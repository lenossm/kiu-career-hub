<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'KIU Career Hub')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root{
            --kiu-blue:#1f5eff;
            --kiu-blue-2:#0b43d7;
            --kiu-ink:#0b1b3a;
            --kiu-muted:#5b6b8a;
            --kiu-border:rgba(11,27,58,.12);
            --shadow: 0 18px 50px rgba(11,27,58,.14);
        }

        body{
            font-family:"Plus Jakarta Sans", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            color: var(--kiu-ink);
            background:
                radial-gradient(900px 520px at 15% 10%, rgba(31,94,255,.18), transparent 60%),
                radial-gradient(800px 520px at 90% 0%, rgba(31,94,255,.12), transparent 60%),
                linear-gradient(180deg, #f7faff, #ffffff 55%, #f6f9ff);
            overflow-x: hidden;
        }

        .reveal{
            animation: pageIn .55s cubic-bezier(.2,.8,.2,1) both;
        }
        @keyframes pageIn{
            from{ opacity:0; transform: translateY(10px); }
            to{ opacity:1; transform:none; }
        }

        .topbar{
            position: sticky;
            top: 0;
            z-index: 10;
            background: rgba(255,255,255,.75);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(11,27,58,.08);
        }
        .brand{
            display:flex; align-items:center; gap:.6rem;
            font-weight:800;
            letter-spacing:.2px;
            color: var(--kiu-ink);
            text-decoration:none;
        }
        .brand-logo{
            height: 30px;
            width: auto;
            display:block;
        }
        .brand-sub{
            font-weight:700;
            letter-spacing:.08em;
            font-size:.72rem;
            color: rgba(11,27,58,.62);
            text-transform: uppercase;
            margin-top: -2px;
        }

        .btn-kiu{
            border:0;
            background: linear-gradient(135deg, var(--kiu-blue), var(--kiu-blue-2));
            box-shadow: 0 16px 40px rgba(31,94,255,.24);
            color:#fff;
            transition: transform .15s ease, box-shadow .15s ease, filter .15s ease;
        }
        .btn-kiu:hover{ transform: translateY(-1px); filter: brightness(1.03); box-shadow: 0 22px 54px rgba(31,94,255,.28); }
        .btn-kiu:active{ transform: translateY(0) scale(.99); }

        .btn-outline-kiu{
            border: 1px solid rgba(31,94,255,.28);
            color: var(--kiu-blue-2);
            background: rgba(31,94,255,.05);
            transition: transform .15s ease, background .15s ease, border-color .15s ease;
        }
        .btn-outline-kiu:hover{ transform: translateY(-1px); background: rgba(31,94,255,.08); border-color: rgba(31,94,255,.38); }

        .hero{
            position:relative;
            padding: 56px 0 20px;
        }
        .hero::before{
            content:"";
            position:absolute;
            inset: -120px -120px auto -120px;
            height: 420px;
            background:
                radial-gradient(520px 260px at 20% 40%, rgba(31,94,255,.28), transparent 60%),
                radial-gradient(520px 260px at 80% 20%, rgba(124,58,237,.18), transparent 60%);
            pointer-events:none;
        }

        .hero-logo{
            width: min(520px, 100%);
            height:auto;
            filter: drop-shadow(0 18px 40px rgba(11,27,58,.10));
            transform-origin: 20% 50%;
            animation: heroPop .75s cubic-bezier(.2,.8,.2,1) both;
        }
        @keyframes heroPop{
            from{ opacity:0; transform: translateY(8px) scale(.98); }
            to{ opacity:1; transform:none; }
        }

        .slogan{
            font-weight:700;
            color: rgba(11,27,58,.72);
            letter-spacing:.02em;
        }

        .kicker{
            display:inline-flex; align-items:center; gap:.5rem;
            padding: .35rem .65rem;
            border-radius: 999px;
            border: 1px solid rgba(11,27,58,.12);
            background: rgba(255,255,255,.65);
            color: var(--kiu-muted);
            box-shadow: 0 10px 30px rgba(11,27,58,.06);
        }
        .kicker i{ color: var(--kiu-blue-2); }

        .headline{
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.05;
        }
        .subhead{
            color: var(--kiu-muted);
            font-size: 1.05rem;
        }

        .feature-card{
            border: 1px solid var(--kiu-border);
            background: rgba(255,255,255,.78);
            border-radius: 18px;
            box-shadow: var(--shadow);
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
            overflow:hidden;
            position:relative;
        }
        .feature-card:hover{
            transform: translateY(-2px);
            border-color: rgba(31,94,255,.22);
            box-shadow: 0 24px 70px rgba(11,27,58,.18);
        }
        .feature-card::before{
            content:"";
            position:absolute; inset:0;
            background:
                radial-gradient(420px 140px at 10% 0%, rgba(31,94,255,.14), transparent 60%),
                radial-gradient(420px 140px at 90% 0%, rgba(124,58,237,.10), transparent 60%);
            pointer-events:none;
        }

        .icon-pill{
            width:44px;height:44px;border-radius:14px;
            display:grid;place-items:center;
            background: rgba(31,94,255,.10);
            border: 1px solid rgba(31,94,255,.18);
            color: var(--kiu-blue-2);
        }

        .wave{
            position:absolute;
            left:0; right:0;
            bottom:-1px;
            height:120px;
            background: linear-gradient(180deg, transparent, rgba(31,94,255,.06));
            mask: radial-gradient(45px 18px at 20px 20px, transparent 98%, #000) repeat-x;
            mask-size: 80px 40px;
            opacity:.9;
        }

        .mock{
            border-radius: 22px;
            border: 1px solid rgba(11,27,58,.10);
            background: linear-gradient(180deg, rgba(255,255,255,.88), rgba(255,255,255,.62));
            box-shadow: 0 26px 80px rgba(11,27,58,.18);
            overflow:hidden;
        }
        .mock-top{
            padding: 12px 16px;
            border-bottom: 1px solid rgba(11,27,58,.08);
            display:flex; align-items:center; justify-content:space-between;
            background: rgba(255,255,255,.82);
        }
        .dots{ display:flex; gap:8px; }
        .dot{ width:10px; height:10px; border-radius:999px; background: rgba(11,27,58,.18); }
        .mock-body{ padding: 16px; }
        .skeleton{
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(90deg, rgba(11,27,58,.08), rgba(31,94,255,.14), rgba(11,27,58,.08));
            background-size: 200% 100%;
            animation: shimmer 1.6s ease-in-out infinite;
        }
        @keyframes shimmer{
            0%{ background-position: 0% 0; }
            100%{ background-position: 200% 0; }
        }

        .footer{
            color: rgba(11,27,58,.55);
            border-top: 1px solid rgba(11,27,58,.08);
            background: rgba(255,255,255,.55);
        }

        @media (prefers-reduced-motion: reduce){
            .reveal, .feature-card, .btn-kiu, .btn-outline-kiu, .skeleton, .hero-logo{ animation:none; transition:none; }
        }
    </style>
</head>
<body>
    <div class="reveal">
        <div class="topbar">
            <div class="container py-3 d-flex justify-content-between align-items-center">
                <a class="brand" href="{{ route('landing') }}">
                    <img class="brand-logo" src="{{ asset('images/kiu-logo.png') }}" alt="Kutaisi International University">
                </a>
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-kiu btn-sm" href="{{ route('vacancies.index') }}">
                        <i class="bi bi-grid-1x2 me-1"></i> Browse
                    </a>
                    @auth
                        <a class="btn btn-kiu btn-sm" href="{{ route('vacancies.create') }}">
                            <i class="bi bi-plus-circle me-1"></i> Post
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-kiu btn-sm" type="submit">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    @else
                        <a class="btn btn-outline-kiu btn-sm" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                        <a class="btn btn-kiu btn-sm" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-1"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        @yield('content')

        <div class="footer py-4 mt-5">
            <div class="container d-flex flex-wrap gap-2 justify-content-between align-items-center">
                <div class="small">© {{ date('Y') }} KIU Career Hub</div>
                <div class="small">
                    <a class="text-decoration-none" href="{{ route('vacancies.index') }}">Opportunities</a>
                    <span class="mx-2">·</span>
                    <a class="text-decoration-none" href="{{ route('vacancies.create') }}">Post</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

