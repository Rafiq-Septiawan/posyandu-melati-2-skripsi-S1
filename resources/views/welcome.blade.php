<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=cormorant-garamond:300,400,500,600&family=dm-mono:300,400" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            *, *::before, *::after {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            :root {
                --cream: #F7F4EF;
                --ink: #1A1814;
                --muted: #8A8780;
                --accent: #C84B2F;
                --line: #E2DDD6;
                --font-display: 'Cormorant Garamond', Georgia, serif;
                --font-mono: 'DM Mono', monospace;
            }

            @media (prefers-color-scheme: dark) {
                :root {
                    --cream: #141210;
                    --ink: #EDE9E2;
                    --muted: #6B6862;
                    --accent: #E06040;
                    --line: #2A2724;
                }
            }

            html, body {
                height: 100%;
            }

            body {
                background-color: var(--cream);
                color: var(--ink);
                font-family: var(--font-display);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                opacity: 0;
                animation: fadeIn 0.8s ease forwards;
            }

            @keyframes fadeIn {
                to { opacity: 1; }
            }

            /* ── Nav ── */
            nav {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                gap: 2rem;
                padding: 2rem 3rem;
                border-bottom: 1px solid var(--line);
            }

            nav a {
                font-family: var(--font-mono);
                font-size: 0.7rem;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--muted);
                text-decoration: none;
                transition: color 0.2s ease;
            }

            nav a:hover {
                color: var(--ink);
            }

            nav a.primary {
                color: var(--ink);
                border-bottom: 1px solid var(--ink);
                padding-bottom: 1px;
            }

            /* ── Main ── */
            main {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 4rem 3rem;
            }

            .container {
                max-width: 780px;
                width: 100%;
            }

            .label {
                font-family: var(--font-mono);
                font-size: 0.65rem;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: var(--muted);
                margin-bottom: 2rem;
                display: block;
                animation: slideUp 0.6s ease 0.1s both;
            }

            .headline {
                font-size: clamp(3.5rem, 8vw, 7rem);
                font-weight: 300;
                line-height: 0.95;
                letter-spacing: -0.02em;
                margin-bottom: 2.5rem;
                animation: slideUp 0.6s ease 0.2s both;
            }

            .headline em {
                font-style: italic;
                color: var(--accent);
            }

            .divider {
                width: 3rem;
                height: 1px;
                background: var(--line);
                margin-bottom: 2.5rem;
                animation: slideUp 0.6s ease 0.3s both;
            }

            .description {
                font-size: 1.15rem;
                font-weight: 300;
                line-height: 1.7;
                color: var(--muted);
                max-width: 460px;
                margin-bottom: 3.5rem;
                animation: slideUp 0.6s ease 0.35s both;
            }

            .actions {
                display: flex;
                align-items: center;
                gap: 2.5rem;
                flex-wrap: wrap;
                animation: slideUp 0.6s ease 0.45s both;
            }

            .btn-primary {
                font-family: var(--font-mono);
                font-size: 0.7rem;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--cream);
                background: var(--ink);
                text-decoration: none;
                padding: 0.9rem 2rem;
                display: inline-block;
                transition: background 0.2s ease, color 0.2s ease;
            }

            .btn-primary:hover {
                background: var(--accent);
            }

            .links {
                display: flex;
                gap: 2rem;
            }

            .links a {
                font-family: var(--font-mono);
                font-size: 0.65rem;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--muted);
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 0.4rem;
                transition: color 0.2s ease;
            }

            .links a:hover {
                color: var(--ink);
            }

            .links a::after {
                content: '↗';
                font-style: normal;
                font-size: 0.7em;
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(16px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* ── Footer ── */
            footer {
                padding: 2rem 3rem;
                border-top: 1px solid var(--line);
                display: flex;
                justify-content: space-between;
                align-items: center;
                animation: slideUp 0.6s ease 0.55s both;
            }

            footer span {
                font-family: var(--font-mono);
                font-size: 0.62rem;
                letter-spacing: 0.1em;
                color: var(--muted);
                text-transform: uppercase;
            }

            footer .version {
                font-size: 0.62rem;
                font-family: var(--font-mono);
                letter-spacing: 0.08em;
                color: var(--line);
                text-transform: uppercase;
            }

            @media (max-width: 600px) {
                nav {
                    padding: 1.5rem;
                }

                main {
                    padding: 3rem 1.5rem;
                    align-items: flex-start;
                }

                footer {
                    padding: 1.5rem;
                    flex-direction: column;
                    gap: 0.5rem;
                    align-items: flex-start;
                }

                .actions {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1.5rem;
                }

                .links {
                    flex-direction: column;
                    gap: 1rem;
                }
            }
        </style>
    </head>
    <body>

        @if (Route::has('login'))
            <nav>
                @auth
                    <a href="{{ url('/dashboard') }}" class="primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="primary">Daftar</a>
                    @endif
                @endauth
            </nav>
        @endif

        <main>
            <div class="container">
                <span class="label">Laravel &mdash; The PHP Framework</span>

                <h1 class="headline">
                    Build something<br><em>remarkable.</em>
                </h1>

                <div class="divider"></div>

                <p class="description">
                    Laravel memberi Anda fondasi yang elegan untuk membangun aplikasi web modern — ekspresif, sederhana, dan menyenangkan.
                </p>

                <div class="actions">
                    <a href="https://cloud.laravel.com" target="_blank" class="btn-primary">Deploy Sekarang</a>

                    <div class="links">
                        <a href="https://laravel.com/docs" target="_blank">Dokumentasi</a>
                        <a href="https://laracasts.com" target="_blank">Laracasts</a>
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <span>{{ config('app.name', 'Laravel') }}</span>
            <span class="version">v{{ app()->version() }}</span>
        </footer>

    </body>
</html>