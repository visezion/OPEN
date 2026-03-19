@extends('marketplace.marketplace')
@section('page-title')
    {{ __('Welcome') }}
@endsection

@php
    $admin_settings = getAdminAllSetting();
    $brand_name = !empty($admin_settings['title_text']) ? $admin_settings['title_text'] : config('app.name', 'Platform');
    $brand_name = preg_replace('/\b(workdo|dash)\b/i', '', (string) $brand_name);
    $brand_name = trim(preg_replace('/\s+/', ' ', (string) $brand_name));
    if ($brand_name === '') {
        $brand_name = 'Platform';
    }

    $theme_palette = [
        'theme-1' => '#0CAF60',
        'theme-2' => '#75C251',
        'theme-3' => '#584ED2',
        'theme-4' => '#145388',
        'theme-5' => '#B9406B',
        'theme-6' => '#008ECC',
        'theme-7' => '#922C88',
        'theme-8' => '#C0A145',
        'theme-9' => '#48494B',
        'theme-10' => '#0C7785',
    ];
    $active_theme = strtolower((string) ($admin_settings['color'] ?? 'theme-1'));
    $landing_primary = $theme_palette[$active_theme] ?? '#145388';
@endphp

@section('content')
    <style>
        .faith-landing {
            --faith-primary: {{ $landing_primary }};
            --faith-primary-ink: #12284a;
            --faith-muted: #5e7392;
            --faith-border: #d6dfec;
            --faith-soft: #eef3fa;
            background: #ffffff;
            color: #10233f;
            font-family: "Overpass", sans-serif;
            padding: 138px 0 210px;
        }

        .faith-landing .container {
            max-width: 1700px;
            margin: 0 auto;
            padding: 0 32px;
        }

        .faith-landing-hero {
            display: grid;
            grid-template-columns: 1.02fr 0.98fr;
            border: 0px solid var(--faith-border);
            border-radius: 22px;
            overflow: hidden;
            background: #fff;
            min-height: 690px;
             box-shadow: 0 18px 36px -32px rgba(22, 55, 98, 0.45);
        }

        .faith-hero-copy {
            padding: 72px 64px;
           
           
        }

        .faith-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.8rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--faith-primary);
            font-weight: 700;
            margin-bottom: 16px;
        }

        .faith-eyebrow::before {
            content: "";
            width: 32px;
            height: 1px;
            background: var(--faith-primary);
        }

        .faith-hero-copy h1 {
            margin: 0;
            font-size: clamp(2.15rem, 3vw, 3.4rem);
            line-height: 1.2;
            color: var(--faith-primary-ink);
            font-weight: 800;
            max-width: 760px;
        }

        .faith-hero-copy p {
            margin: 22px 0 0;
            color: var(--faith-muted);
            font-size: 1.08rem;
            line-height: 1.72;
            max-width: 690px;
        }

        .faith-hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 34px;
        }

        .faith-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 47px;
            padding: 0 22px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            letter-spacing: 0.01em;
            border: 1px solid transparent;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease, color .18s ease, filter .18s ease;
        }

        .faith-btn-primary {
            background: var(--faith-primary);
            color: #fff;
        }

        .faith-btn-primary:hover {
            filter: brightness(0.95);
            transform: translateY(-1px);
            box-shadow: 0 12px 24px -16px color-mix(in srgb, var(--faith-primary) 55%, #0f233f);
            color: #fff;
        }

        .faith-btn-outline {
            border-color: var(--faith-border);
            color: var(--faith-primary-ink);
            background: #fff;
        }

        .faith-btn-outline:hover {
            border-color: var(--faith-primary);
            color: var(--faith-primary);
            background: #fbfdff;
        }

        .faith-hero-note {
            margin-top: 22px;
            font-size: 0.98rem;
            color: #6981a1;
        }

        .faith-hero-map {
            position: relative;
            min-height: 590px;
            background: #f8fbff;
            overflow: hidden;
        }

        .faith-grid-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(33, 70, 122, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(33, 70, 122, 0.08) 1px, transparent 1px);
            background-size: 42px 42px;
        }

        .faith-core {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 246px;
            height: 246px;
            border-radius: 50%;
            border: 1px solid rgba(20, 83, 136, 0.24);
            background: #fff;
            box-shadow: 0 22px 44px -28px rgba(22, 56, 102, 0.35);
            display: grid;
            place-items: center;
            text-align: center;
            z-index: 2;
        }

        .faith-core p {
            margin: 0;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: #6f87a7;
            font-weight: 700;
        }

        .faith-core h3 {
            margin: 8px 0 4px;
            color: var(--faith-primary);
            font-size: 2.65rem;
            line-height: 1.05;
            font-weight: 800;
        }

        .faith-core span {
            color: #557195;
            font-size: 0.86rem;
            font-weight: 700;
            letter-spacing: 0.03em;
        }

        .faith-node {
            position: absolute;
            padding: 11px 16px;
            background: #fff;
            border: 1px solid #d8e3f1;
            border-radius: 12px;
            box-shadow: 0 14px 30px -24px rgba(15, 40, 77, 0.45);
            color: #395578;
            font-size: 0.93rem;
            font-weight: 700;
            z-index: 2;
            white-space: nowrap;
        }

        .faith-node::after {
            content: "";
            position: absolute;
            inset: auto auto -11px 50%;
            width: 2px;
            height: 10px;
            background: #8aa4c5;
            transform: translateX(-50%);
            opacity: 0;
        }

        .faith-node-a { top: 58px; left: 56px; }
        .faith-node-b { top: 66px; right: 68px; }
        .faith-node-c { left: 48px; top: 210px; }
        .faith-node-d { right: 52px; top: 206px; }
        .faith-node-e { bottom: 78px; left: 94px; }
        .faith-node-f { bottom: 82px; right: 96px; }

        .faith-ring {
            position: absolute;
            border-radius: 999px;
            border: 1px dashed rgba(71, 103, 145, 0.34);
            inset: 62px 84px;
            animation: spinSlow 20s linear infinite;
        }

        .faith-ring.r2 {
            inset: 110px 132px;
            animation-direction: reverse;
            animation-duration: 16s;
        }

        .faith-kpis {
            margin-top: 28px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .faith-kpi {
            border: 1px solid var(--faith-border);
            border-radius: 14px;
            padding: 20px 22px;
            background: #fff;
            min-height: 132px;
            box-shadow: 0 12px 24px -26px rgba(20, 48, 86, 0.42);
        }

        .faith-kpi strong {
            display: block;
            color: var(--faith-primary-ink);
            font-size: 1.15rem;
            font-weight: 800;
        }

        .faith-kpi span {
            display: block;
            margin-top: 5px;
            color: var(--faith-muted);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .faith-section-title {
            margin: 62px 0 22px;
            font-size: 1.45rem;
            color: var(--faith-primary-ink);
            font-weight: 800;
        }

        .faith-feature-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .faith-feature-card {
            border: 1px solid var(--faith-border);
            border-radius: 16px;
            padding: 24px 22px;
            background: #fff;
            min-height: 206px;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .faith-feature-card:hover {
            transform: translateY(-2px);
            border-color: #a8bfdc;
            box-shadow: 0 16px 30px -24px rgba(23, 56, 97, 0.35);
        }

        .faith-feature-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--faith-primary);
            box-shadow: 0 0 0 8px rgba(21, 84, 138, 0.08);
            margin-bottom: 14px;
        }

        .faith-feature-card h3 {
            margin: 0;
            color: var(--faith-primary-ink);
            font-size: 1.03rem;
            font-weight: 800;
        }

        .faith-feature-card p {
            margin: 10px 0 0;
            color: var(--faith-muted);
            line-height: 1.7;
            font-size: 0.94rem;
        }

        .faith-bottom-cta {
            margin-top: 58px;
            border-radius: 18px;
            border: 1px solid var(--faith-border);
            background: linear-gradient(132deg, #f5f9ff 0%, #ffffff 78%);
            padding: 38px 34px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            box-shadow: 0 18px 36px -32px rgba(22, 55, 98, 0.45);
        }

        .faith-bottom-cta h3 {
            margin: 0;
            color: var(--faith-primary-ink);
            font-size: 1.35rem;
            font-weight: 800;
        }

        .faith-bottom-cta p {
            margin: 8px 0 0;
            color: var(--faith-muted);
            font-size: 0.95rem;
        }

        .faith-bottom-cta .faith-hero-actions {
            margin-top: 0;
        }

        .site-header.header-style-one .main-navigationbar {
            background: #ffffff;
            border-bottom: 1px solid #d9e3f0;
            box-shadow: 0 8px 26px -24px rgba(18, 41, 77, 0.48);
        }

        .site-header .main-nav .menu-lnk > a {
            color: #233a5b;
            font-weight: 700;
        }

        .site-header .main-nav .menu-lnk > a:hover {
            color: var(--faith-primary);
        }

        .site-footer {
            margin-top: 0;
        }

        @keyframes spinSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @media (max-width: 1100px) {
            .faith-landing-hero {
                grid-template-columns: 1fr;
                min-height: unset;
            }
            .faith-hero-copy {
                border-right: 0;
                border-bottom: 1px solid var(--faith-border);
                padding: 52px 34px;
            }
            .faith-hero-map {
                min-height: 500px;
            }
            .faith-kpis {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .faith-feature-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            .faith-landing {
                padding: 58px 0 82px;
            }
            .faith-hero-copy {
                padding: 32px 22px;
            }
            .faith-hero-map {
                min-height: 390px;
            }
            .faith-core {
                width: 168px;
                height: 168px;
            }
            .faith-core h3 {
                font-size: 1.7rem;
            }
            .faith-node {
                font-size: 0.76rem;
                padding: 7px 10px;
            }
            .faith-node-a { top: 34px; left: 20px; }
            .faith-node-b { top: 40px; right: 20px; }
            .faith-node-c { top: 175px; left: 16px; }
            .faith-node-d { top: 170px; right: 16px; }
            .faith-node-e { bottom: 34px; left: 28px; }
            .faith-node-f { bottom: 36px; right: 24px; }
            .faith-feature-grid {
                grid-template-columns: 1fr;
            }
            .faith-kpis {
                grid-template-columns: 1fr;
            }
            .faith-feature-card {
                min-height: unset;
            }
            .faith-kpi {
                min-height: 112px;
            }
            .faith-bottom-cta {
                padding: 28px 20px;
            }
        }
    </style>

    <div class="faith-landing">
        <div class="container">
            <section class="faith-landing-hero">
                <div class="faith-hero-copy">
                    <p class="faith-eyebrow">{{ __('Faith Operations Hub') }}</p>
                    <h2>{{ __('A unified ministry and business control center for every team, task, and report.') }}</h2>
                    <p>{{ __('Built to continue your secure login experience with a clean operational view, trusted structure, and accountability-first workflows.') }}</p>
                    <div class="faith-hero-actions">
                        <a class="faith-btn faith-btn-primary" href="{{ Auth::check() ? route('home') : route('login') }}">
                            {{ Auth::check() ? __('Open Dashboard') : __('Sign In') }}
                        </a>
                        @if (empty($admin_settings['signup']) || (isset($admin_settings['signup']) ? $admin_settings['signup'] : 'off') == 'on')
                            <a class="faith-btn faith-btn-outline" href="{{ route('register') }}">{{ __('Create Account') }}</a>
                        @endif
                        <a class="faith-btn faith-btn-outline" href="{{ route('apps.pricing') }}">{{ __('View Plans') }}</a>
                    </div>
                    <p class="faith-hero-note">{{ __('This app is free and open source, built to help your team grow with confidence.') }}</p>
                </div>
                <div class="faith-hero-map" aria-hidden="true">
                    <div class="faith-grid-bg"></div>
                    <div class="faith-ring"></div>
                    <div class="faith-ring r2"></div>
                    <div class="faith-node faith-node-a">{{ __('Prayer Requests') }}</div>
                    <div class="faith-node faith-node-b">{{ __('Service Reports') }}</div>
                    <div class="faith-node faith-node-c">{{ __('Discipleship') }}</div>
                    <div class="faith-node faith-node-d">{{ __('Finance Notes') }}</div>
                    <div class="faith-node faith-node-e">{{ __('Outreach Tasks') }}</div>
                    <div class="faith-node faith-node-f">{{ __('Team Scheduling') }}</div>
                    <div class="faith-core">
                        <div>
                            <p>{{ __('Control Plane') }}</p>
                            <h3>{{ $brand_name }}</h3>
                            <span>{{ __('In Christ Jesus') }}</span>
                        </div>
                    </div>
                </div>
            </section>
            <section class="faith-kpis">
                <article class="faith-kpi">
                    <strong>{{ __('One Workspace') }}</strong>
                    <span>{{ __('Unify people, permissions, and records.') }}</span>
                </article>
                <article class="faith-kpi">
                    <strong>{{ __('Secure Access') }}</strong>
                    <span>{{ __('Controlled sign-in with audit-focused flows.') }}</span>
                </article>
                <article class="faith-kpi">
                    <strong>{{ __('Module Ready') }}</strong>
                    <span>{{ __('Grow features as ministry operations expand.') }}</span>
                </article>
                <article class="faith-kpi">
                    <strong>{{ __('Clear Reporting') }}</strong>
                    <span>{{ __('Track accountability and operational progress.') }}</span>
                </article>
            </section>

            <h2 class="faith-section-title">{{ __('Why this interface works for your teams') }}</h2>
            <section class="faith-feature-grid">
                <article class="faith-feature-card">
                    <div class="faith-feature-dot"></div>
                    <h3>{{ __('Consistent experience') }}</h3>
                    <p>{{ __('Landing, login, and register now follow one visual system for better trust and easier navigation.') }}</p>
                </article>
                <article class="faith-feature-card">
                    <div class="faith-feature-dot"></div>
                    <h3>{{ __('Faith-aligned language') }}</h3>
                    <p>{{ __('Messaging and structure stay aligned to your ministry direction without generic corporate wording.') }}</p>
                </article>
                <article class="faith-feature-card">
                    <div class="faith-feature-dot"></div>
                    <h3>{{ __('Primary color sync') }}</h3>
                    <p>{{ __('Accent styling reflects super admin branding so every public entry screen remains consistent.') }}</p>
                </article>
                <article class="faith-feature-card">
                    <div class="faith-feature-dot"></div>
                    <h3>{{ __('Mobile-first behavior') }}</h3>
                    <p>{{ __('Hero and cards adapt cleanly on tablets and phones with preserved spacing and hierarchy.') }}</p>
                </article>
                <article class="faith-feature-card">
                    <div class="faith-feature-dot"></div>
                    <h3>{{ __('No legacy clutter') }}</h3>
                    <p>{{ __('Removed legacy marketplace blocks and visuals that conflicted with your current identity.') }}</p>
                </article>
                <article class="faith-feature-card">
                    <div class="faith-feature-dot"></div>
                    <h3>{{ __('Action-ready flow') }}</h3>
                    <p>{{ __('Visitors can move directly from landing to sign-in, registration, or plan selection without confusion.') }}</p>
                </article>
            </section>

            <section class="faith-bottom-cta">
                <div>
                    <h3>{{ __('Ready to continue with the new faith-aligned experience?') }}</h3>
                    <p>{{ __('Start from secure sign-in or create a workspace and move directly into operations.') }}</p>
                </div>
                <div class="faith-hero-actions">
                    <a class="faith-btn faith-btn-primary" href="{{ Auth::check() ? route('home') : route('login') }}">
                        {{ Auth::check() ? __('Open Dashboard') : __('Sign In') }}
                    </a>
                    @if (empty($admin_settings['signup']) || (isset($admin_settings['signup']) ? $admin_settings['signup'] : 'off') == 'on')
                        <a class="faith-btn faith-btn-outline" href="{{ route('register') }}">{{ __('Create Account') }}</a>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
