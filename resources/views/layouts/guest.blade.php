<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | POS Toko</title>
    <link rel="stylesheet" href="{{ asset('teamplate/css/adminlte.min.css') }}">
    <style>
        :root {
            color-scheme: light;
            --auth-forest: #174b40;
            --auth-leaf: #d7ee79;
            --auth-ink: #203238;
            --auth-muted: #68777a;
            --auth-border: #dce5e1;
        }

        .auth-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px;
            background: #e9efeb;
        }

        .auth-shell {
            width: min(100%, 940px);
            min-height: 560px;
            display: grid;
            grid-template-columns: minmax(270px, 0.82fr) minmax(360px, 1.18fr);
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--auth-border);
            border-radius: 8px;
            box-shadow: 0 24px 70px rgb(26 56 47 / 12%);
        }

        .auth-brand-panel {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 36px;
            color: #fff;
            background: var(--auth-forest);
        }

        .auth-brand-link {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            width: fit-content;
            color: #fff;
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
        }

        .auth-brand-mark {
            display: grid;
            width: 42px;
            aspect-ratio: 1;
            place-items: center;
            color: var(--auth-forest);
            background: var(--auth-leaf);
            border-radius: 6px;
            font-size: 14px;
        }

        .auth-brand-copy {
            max-width: 270px;
            margin: 48px 0;
        }

        .auth-brand-label,
        .auth-eyebrow {
            margin: 0 0 12px;
            color: var(--auth-muted);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
        }

        .auth-brand-label {
            color: var(--auth-leaf);
        }

        .auth-brand-title {
            margin: 0;
            color: #fff;
            font-size: 34px;
            font-weight: 700;
        }

        .auth-brand-footer {
            margin: 0;
            padding-top: 16px;
            color: rgb(255 255 255 / 72%);
            border-top: 1px solid rgb(255 255 255 / 18%);
            font-size: 13px;
        }

        .auth-form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 64px;
        }

        .auth-form-body {
            width: 100%;
            max-width: 380px;
        }

        .auth-title {
            margin: 0 0 8px;
            color: var(--auth-ink);
            font-size: 30px;
            font-weight: 700;
        }

        .auth-description {
            margin: 0 0 28px;
            color: var(--auth-muted);
        }

        .auth-form-body .form-label {
            color: var(--auth-ink);
            font-weight: 600;
        }

        .auth-form-body .form-control {
            min-height: 46px;
            border-color: var(--auth-border);
            border-radius: 4px;
        }

        .auth-form-body .form-control:focus {
            border-color: var(--auth-forest);
            box-shadow: 0 0 0 3px rgb(23 75 64 / 12%);
        }

        .auth-form-body .btn-primary {
            min-height: 46px;
            color: #fff;
            background: var(--auth-forest);
            border-color: var(--auth-forest);
            border-radius: 4px;
            font-weight: 600;
        }

        .auth-form-body .btn-primary:hover {
            background: #103c33;
            border-color: #103c33;
        }

        .auth-secondary-link,
        .auth-register-prompt a {
            color: var(--auth-forest);
            font-weight: 600;
        }

        .auth-register-prompt {
            margin: 24px 0 0;
            color: var(--auth-muted);
            text-align: center;
        }

        @media (max-width: 720px) {
            .auth-page {
                padding: 0;
                background: #fff;
            }

            .auth-shell {
                min-height: 100vh;
                grid-template-columns: 1fr;
                border: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .auth-brand-panel {
                min-height: 148px;
                gap: 20px;
                padding: 24px;
            }

            .auth-brand-copy {
                display: none;
            }

            .auth-brand-footer {
                padding-top: 12px;
            }

            .auth-form-panel {
                align-items: flex-start;
                padding: 32px 24px 40px;
            }
        }
    </style>
</head>
<body>
    <main class="auth-page">
        <section class="auth-shell">
            <aside class="auth-brand-panel">
                <a class="auth-brand-link" href="{{ route('home') }}">
                    <span class="auth-brand-mark" aria-hidden="true">POS</span>
                    <span>POS Toko</span>
                </a>
                <div class="auth-brand-copy">
                    <p class="auth-brand-label">OPERASIONAL TOKO</p>
                    <h2 class="auth-brand-title">POS Toko</h2>
                </div>
                <p class="auth-brand-footer">Akses akun toko Anda</p>
            </aside>
            <section class="auth-form-panel">
                @yield('content')
            </section>
        </section>
    </main>
</body>
</html>
