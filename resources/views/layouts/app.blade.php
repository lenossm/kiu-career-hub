<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'KIU Career Hub') — KIU Career Hub</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#040B14">
    {{-- Dark canvas before Bootstrap/app.css so navigations never flash white --}}
    <style>html,body{background:#040B14!important;background-color:#040B14!important;color-scheme:dark}</style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/css/app.css?v=18" rel="stylesheet">
    <script>
        (function () {
            try {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                // kiu-motion: scroll reveal; kiu-page-enter: near-invisible main opacity
                document.documentElement.classList.add('kiu-motion', 'kiu-page-enter');
            } catch (err) {}
        })();
    </script>
</head>
<body class="@yield('body_class')">
<div class="kiu-ambient" aria-hidden="true"></div>

@include('partials.navbar')

@php
    $useSidebar = auth()->check() && !request()->routeIs('home', 'login', 'register');
@endphp

<div class="container py-4 py-lg-5">
    <div class="kiu-app-shell {{ $useSidebar ? 'has-sidebar' : '' }}">
        @if($useSidebar)
            @include('partials.sidebar')
        @endif

        <main class="kiu-main-content">
            @if($useSidebar)
                @include('partials.mobile-nav')
            @endif

            @include('partials.flash')
            @yield('content')
        </main>
    </div>
</div>

<div class="kiu-toast" aria-live="polite" aria-atomic="true">
    <div id="appToast" class="toast align-items-center" role="status">
        <div class="d-flex">
            <div class="toast-body" id="appToastBody">Updated.</div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const toastEl = document.getElementById('appToast');
        const toastBody = document.getElementById('appToastBody');
        const toast = toastEl ? bootstrap.Toast.getOrCreateInstance(toastEl, { delay: 1800 }) : null;

        function showToast(message) {
            if (!toast || !toastBody) return;
            toastBody.textContent = message;
            toast.show();
        }

        document.addEventListener('submit', async (e) => {
            const form = e.target;
            if (!(form instanceof HTMLFormElement)) return;
            const isVacancyToggle = form.classList.contains('js-toggle-status');
            const isTaskToggle = form.classList.contains('js-toggle-task-status');
            if (!isVacancyToggle && !isTaskToggle) return;

            e.preventDefault();

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf ?? '',
                    },
                    body: new FormData(form),
                });

                if (!res.ok) {
                    showToast('Could not update status.');
                    return;
                }

                const data = await res.json();
                const itemId = String(data.id);
                const newStatus = String(data.status);

                const selector = isVacancyToggle ? `[data-vacancy-id="${itemId}"]` : `[data-task-id="${itemId}"]`;
                document.querySelectorAll(selector).forEach((node) => {
                    const badge = node.querySelector('[data-role="status-badge"]');
                    const btn = node.querySelector('[data-role="toggle-button"]');
                    if (badge) {
                        badge.classList.remove('kiu-badge-open', 'kiu-badge-closed', 'kiu-badge-pending');
                        if (newStatus === 'done') {
                            badge.classList.add('kiu-badge-closed');
                            badge.innerHTML = '<i class="bi bi-check-circle"></i> Done';
                        } else {
                            badge.classList.add('kiu-badge-open');
                            badge.innerHTML = '<i class="bi bi-hourglass-split"></i> Pending';
                        }
                    }
                    if (btn) {
                        if (isVacancyToggle) {
                            btn.textContent = newStatus === 'done' ? 'Reopen' : 'Mark as Done';
                        } else {
                            btn.textContent = newStatus === 'done' ? 'Mark Pending' : 'Mark Done';
                        }
                    }
                });

                showToast(isVacancyToggle ? 'Vacancy status updated.' : 'Task status updated.');
            } catch (err) {
                showToast('Network error.');
            }
        });

        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const animSel = '.anim-fade-up, .anim-fade-in, .anim-slide-in-right, .anim-pop';

        if (document.documentElement.classList.contains('kiu-page-enter')) {
            window.setTimeout(() => {
                document.documentElement.classList.remove('kiu-page-enter');
            }, 120);
        }

        // Scroll reveal: above-fold stays visible; below-fold gets reveal-ready.
        if (!prefersReduced && 'IntersectionObserver' in window) {
            const io = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -4% 0px' });

            const vh = window.innerHeight || document.documentElement.clientHeight;
            document.querySelectorAll(animSel).forEach((el) => {
                const rect = el.getBoundingClientRect();
                if (rect.top < vh * 0.96 && rect.bottom > 0) {
                    el.classList.add('is-visible');
                } else {
                    el.classList.add('reveal-ready');
                    io.observe(el);
                }
            });
        } else {
            document.querySelectorAll(animSel).forEach((el) => {
                el.classList.add('is-visible');
            });
        }

        if (!prefersReduced) {
            const tiltTargets = document.querySelectorAll('.kiu-step-card, .kiu-feature-role');
            tiltTargets.forEach((card) => {
                card.classList.add('kiu-tilt');
                card.addEventListener('pointermove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = (e.clientX - rect.left) / rect.width;
                    const y = (e.clientY - rect.top) / rect.height;
                    const rotY = (x - 0.5) * 12;
                    const rotX = (0.5 - y) * 10;
                    card.classList.add('is-tilting');
                    card.style.transform = `perspective(900px) rotateX(${rotX}deg) rotateY(${rotY}deg) translateY(-4px)`;
                });
                card.addEventListener('pointerleave', () => {
                    card.classList.remove('is-tilting');
                    card.style.transform = '';
                });
            });
        }
    })();
</script>
@stack('scripts')
</body>
</html>
