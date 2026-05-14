<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Openzion') }} - {{ __('Page Expired') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ui-clean.css') }}">

    <style>
        :root {
            --expired-ink: #10203a;
            --expired-copy: #61708a;
            --expired-soft: #8ea0bd;
            --expired-paper: rgba(255, 255, 255, 0.88);
            --expired-line: rgba(148, 163, 184, 0.22);
            --expired-accent: #1d4ed8;
            --expired-accent-2: #0f766e;
            --expired-warm: #f59e0b;
        }

        * {
            box-sizing: border-box;
        }

        body.expired-page {
            margin: 0;
            min-height: 100vh;
            color: var(--expired-ink);
            font-family: "Georgia", "Palatino Linotype", "Book Antiqua", serif;
            background:
                radial-gradient(circle at top left, rgba(29, 78, 216, 0.16), transparent 28%),
                radial-gradient(circle at bottom right, rgba(15, 118, 110, 0.16), transparent 26%),
                linear-gradient(140deg, #eef4fb 0%, #f9fbfe 44%, #eef7f6 100%);
            position: relative;
            overflow-x: hidden;
        }

        body.expired-page::before,
        body.expired-page::after {
            content: "";
            position: fixed;
            inset: auto;
            border-radius: 999px;
            pointer-events: none;
            filter: blur(4px);
        }

        body.expired-page::before {
            top: 6%;
            right: -120px;
            width: 320px;
            height: 320px;
            background: rgba(37, 99, 235, 0.08);
        }

        body.expired-page::after {
            left: -90px;
            bottom: 8%;
            width: 260px;
            height: 260px;
            background: rgba(15, 118, 110, 0.08);
        }

        .expired-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            position: relative;
            z-index: 1;
        }

        .expired-frame {
            width: min(1120px, 100%);
            border: 1px solid var(--expired-line);
            background: var(--expired-paper);
            backdrop-filter: blur(18px);
            border-radius: 32px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .expired-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
        }

        .expired-story {
            position: relative;
            padding: 52px 48px 44px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.74), rgba(255, 255, 255, 0.92)),
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 31px,
                    rgba(148, 163, 184, 0.08) 31px,
                    rgba(148, 163, 184, 0.08) 32px
                );
        }

        .expired-story::after {
            content: "";
            position: absolute;
            top: 28px;
            right: 28px;
            width: 124px;
            height: 124px;
            border-radius: 28px;
            background:
                linear-gradient(135deg, rgba(29, 78, 216, 0.12), rgba(15, 118, 110, 0.16));
            transform: rotate(10deg);
        }

        .expired-kicker {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(148, 163, 184, 0.22);
            color: var(--expired-accent);
            font-size: 0.8rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
            font-weight: 700;
        }

        .expired-kicker__dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(180deg, var(--expired-accent), var(--expired-accent-2));
            box-shadow: 0 0 0 6px rgba(29, 78, 216, 0.08);
        }

        .expired-code {
            margin: 28px 0 10px;
            font-size: clamp(4rem, 12vw, 7rem);
            line-height: 0.9;
            font-weight: 700;
            letter-spacing: -0.06em;
            color: #0f172a;
        }

        .expired-title {
            margin: 0;
            max-width: 620px;
            font-size: clamp(2rem, 4vw, 3.25rem);
            line-height: 1.02;
            font-weight: 700;
            letter-spacing: -0.04em;
            color: var(--expired-ink);
        }

        .expired-copy {
            margin: 22px 0 0;
            max-width: 620px;
            color: var(--expired-copy);
            font-size: 1.04rem;
            line-height: 1.85;
            font-family: "Segoe UI", sans-serif;
        }

        .expired-rail {
            display: grid;
            gap: 16px;
            margin-top: 32px;
        }

        .expired-note {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 14px;
            padding: 18px 18px 18px 16px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(148, 163, 184, 0.16);
        }

        .expired-note__icon {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            font-size: 1rem;
            font-family: "Segoe UI", sans-serif;
            font-weight: 800;
            color: #0f172a;
        }

        .expired-note:nth-child(1) .expired-note__icon {
            background: rgba(29, 78, 216, 0.12);
        }

        .expired-note:nth-child(2) .expired-note__icon {
            background: rgba(245, 158, 11, 0.14);
        }

        .expired-note strong {
            display: block;
            margin-bottom: 4px;
            color: var(--expired-ink);
            font-family: "Segoe UI", sans-serif;
            font-size: 0.95rem;
        }

        .expired-note span {
            color: var(--expired-copy);
            font-family: "Segoe UI", sans-serif;
            font-size: 0.93rem;
            line-height: 1.65;
        }

        .expired-panel {
            padding: 42px 34px;
            background:
                linear-gradient(180deg, rgba(16, 32, 58, 0.97), rgba(13, 25, 46, 0.96));
            color: #f8fbff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 26px;
        }

        .expired-panel__card {
            padding: 22px 22px 20px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .expired-panel__eyebrow {
            margin: 0 0 8px;
            color: #93c5fd;
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            font-family: "Segoe UI", sans-serif;
            font-weight: 700;
        }

        .expired-panel__title {
            margin: 0 0 10px;
            font-size: 1.35rem;
            font-weight: 700;
            color: #ffffff;
        }

        .expired-panel__copy {
            margin: 0;
            color: rgba(226, 232, 240, 0.82);
            line-height: 1.7;
            font-family: "Segoe UI", sans-serif;
        }

        .expired-actions {
            display: grid;
            gap: 12px;
            margin-top: 22px;
        }

        .expired-actions .btn {
            width: 100%;
            min-height: 52px;
            border-radius: 16px;
            font-family: "Segoe UI", sans-serif;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .expired-actions .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #0f766e 100%);
            border: 0;
            box-shadow: 0 18px 36px rgba(37, 99, 235, 0.18);
        }

        .expired-actions .btn-outline-light {
            border-width: 1px;
            color: #f8fbff;
        }

        .expired-tiplist {
            margin: 0;
            padding: 0;
            list-style: none;
            display: grid;
            gap: 12px;
        }

        .expired-tiplist li {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 12px;
            align-items: start;
            color: rgba(226, 232, 240, 0.82);
            font-family: "Segoe UI", sans-serif;
            line-height: 1.6;
        }

        .expired-tiplist span {
            width: 26px;
            height: 26px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(59, 130, 246, 0.16);
            color: #bfdbfe;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .expired-footer {
            padding-top: 6px;
            color: rgba(191, 219, 254, 0.72);
            font-size: 0.88rem;
            font-family: "Segoe UI", sans-serif;
        }

        @media (max-width: 960px) {
            .expired-grid {
                grid-template-columns: 1fr;
            }

            .expired-story,
            .expired-panel {
                padding: 32px 24px;
            }

            .expired-story::after {
                width: 92px;
                height: 92px;
                top: 20px;
                right: 20px;
            }
        }

        @media (max-width: 640px) {
            .expired-shell {
                padding: 16px;
            }

            .expired-frame {
                border-radius: 24px;
            }

            .expired-story,
            .expired-panel {
                padding: 26px 18px;
            }

            .expired-title {
                font-size: 1.8rem;
            }

            .expired-copy {
                font-size: 0.96rem;
            }
        }
    </style>
</head>
<body class="expired-page ui-border-clean">
    <main class="expired-shell">
        <section class="expired-frame" aria-labelledby="expired-title">
            <div class="expired-grid">
                <div class="expired-story">
                    <div class="expired-kicker">
                        <span class="expired-kicker__dot"></span>
                        {{ __('Session Timeout') }}
                    </div>

                    <p class="expired-code">419</p>
                    <h1 class="expired-title" id="expired-title">{{ __('This page lost its secure session.') }}</h1>
                    <p class="expired-copy">
                        {{ __('The form or action you opened is no longer holding a valid security token. This usually means the session sat too long, the page was duplicated in other tabs, or the browser sent an older form state back to the server.') }}
                    </p>

                    <div class="expired-rail">
                        <article class="expired-note">
                            <div class="expired-note__icon">01</div>
                            <div>
                                <strong>{{ __('What happened') }}</strong>
                                <span>{{ __('OPEN blocked the request because the page token expired before submission, which is safer than accepting an outdated form.') }}</span>
                            </div>
                        </article>

                        <article class="expired-note">
                            <div class="expired-note__icon">02</div>
                            <div>
                                <strong>{{ __('Best next step') }}</strong>
                                <span>{{ __('Refresh this page first, then repeat the action from a fresh screen so the new session token is used.') }}</span>
                            </div>
                        </article>
                    </div>
                </div>

                <aside class="expired-panel">
                    <div class="expired-panel__card">
                        <p class="expired-panel__eyebrow">{{ __('Recover Quickly') }}</p>
                        <h2 class="expired-panel__title">{{ __('Get back into the flow') }}</h2>
                        <p class="expired-panel__copy">
                            {{ __('Use the actions below to reopen the request safely. If you were editing a long form, refresh first before re-entering anything important.') }}
                        </p>

                        <div class="expired-actions">
                            <a href="{{ url()->current() }}" class="btn btn-primary">{{ __('Refresh This Page') }}</a>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-light">{{ __('Return To Previous Page') }}</a>
                        </div>
                    </div>

                    <div class="expired-panel__card">
                        <p class="expired-panel__eyebrow">{{ __('Helpful Checks') }}</p>
                        <ul class="expired-tiplist">
                            <li>
                                <span>1</span>
                                <div>{{ __('If you had multiple copies of the same form open, close the older tabs and keep only one active version.') }}</div>
                            </li>
                            <li>
                                <span>2</span>
                                <div>{{ __('If you signed out in another window, sign in again before retrying the action.') }}</div>
                            </li>
                            <li>
                                <span>3</span>
                                <div>{{ __('If this repeats often on one screen, it may be worth reviewing that workflow for long idle form sessions.') }}</div>
                            </li>
                        </ul>
                    </div>

                    <div class="expired-footer">
                        {{ __('Status') }}: 419 · {{ __('Page Expired') }}
                    </div>
                </aside>
            </div>
        </section>
    </main>
</body>
</html>
