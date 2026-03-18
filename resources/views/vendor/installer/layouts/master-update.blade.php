@php
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

    $brand_name = config('app.name', 'Openzion');
    $primary_color = '#145388';

    if (function_exists('getAdminAllSetting')) {
        $admin_settings = getAdminAllSetting();
        $brand_name = !empty($admin_settings['title_text']) ? $admin_settings['title_text'] : $brand_name;
        $setting_color = strtolower(trim((string) ($admin_settings['color'] ?? '')));

        if (isset($theme_palette[$setting_color])) {
            $primary_color = $theme_palette[$setting_color];
        } else {
            $raw_color = trim((string) ($admin_settings['color'] ?? ''));
            if ($raw_color !== '') {
                if (strpos($raw_color, '#') !== 0) {
                    $raw_color = '#' . $raw_color;
                }
                if (preg_match('/^#[0-9a-fA-F]{3,8}$/', $raw_color)) {
                    $primary_color = $raw_color;
                }
            }
        }
    }

    $is_welcome = request()->routeIs('LaravelUpdater::welcome');
    $is_overview = request()->routeIs('LaravelUpdater::overview') || request()->routeIs('LaravelUpdater::database');
    $is_final = request()->routeIs('LaravelUpdater::final');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ trans('installer_messages.updater.title') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-16x16.png') }}" sizes="16x16"/>
        <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-32x32.png') }}" sizes="32x32"/>
        <link rel="icon" type="image/png" href="{{ asset('installer/img/favicon/favicon-96x96.png') }}" sizes="96x96"/>
        <link href="{{ asset('installer/css/style.min.css') }}" rel="stylesheet"/>
        <style>
            :root {
                --update-primary: {{ $primary_color }};
                --update-primary-deep: #12284c;
                --update-border: #d7dfeb;
                --update-bg: #f5f8fc;
                --update-text: #1d2f50;
                --update-muted: #61728f;
            }
            body.update-body {
                margin: 0;
                font-family: "Overpass", "Segoe UI", Arial, sans-serif;
                color: var(--update-text);
                background:
                    radial-gradient(circle at 0 0, rgba(20, 83, 136, 0.10), transparent 40%),
                    radial-gradient(circle at 100% 100%, rgba(20, 83, 136, 0.08), transparent 42%),
                    var(--update-bg);
                min-height: 100vh;
            }
            .update-shell {
                max-width: 1160px;
                margin: 0 auto;
                padding: 56px 24px 40px;
            }
            .update-grid {
                display: grid;
                grid-template-columns: 1.55fr .95fr;
                gap: 24px;
                align-items: stretch;
            }
            .update-card {
                background: #fff;
                border: 1px solid var(--update-border);
                border-radius: 22px;
                box-shadow: 0 24px 48px rgba(15, 30, 60, 0.08);
                overflow: hidden;
            }
            .update-main-head {
                padding: 30px 34px 18px;
                border-bottom: 1px solid var(--update-border);
                background: linear-gradient(180deg, rgba(20, 83, 136, 0.06), rgba(20, 83, 136, 0));
            }
            .update-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                margin: 0;
                font-size: 12px;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                font-weight: 800;
                color: var(--update-primary);
            }
            .update-badge::before {
                content: "";
                width: 9px;
                height: 9px;
                border-radius: 50%;
                background: var(--update-primary);
            }
            .update-title {
                margin: 12px 0 0;
                font-size: 34px;
                line-height: 1.14;
                color: var(--update-primary-deep);
            }
            .update-subtitle {
                margin: 12px 0 0;
                max-width: 780px;
                color: var(--update-muted);
                font-size: 16px;
                line-height: 1.6;
            }
            .update-steps {
                display: flex;
                gap: 12px;
                padding: 16px 34px 20px;
                border-bottom: 1px solid var(--update-border);
                flex-wrap: wrap;
                background: #fff;
            }
            .update-step {
                min-width: 150px;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                border: 1px solid var(--update-border);
                border-radius: 999px;
                padding: 8px 12px;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .07em;
                color: #5f7291;
                background: #f8fbff;
            }
            .update-step-index {
                width: 22px;
                height: 22px;
                border-radius: 50%;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 11px;
                background: #e8eef7;
                color: #35517c;
                font-weight: 800;
            }
            .update-step.active {
                border-color: var(--update-primary);
                color: var(--update-primary);
                background: rgba(20, 83, 136, 0.08);
            }
            .update-step.active .update-step-index {
                background: var(--update-primary);
                color: #fff;
            }
            .update-main-body {
                padding: 30px 34px 34px;
            }
            .update-aside {
                padding: 30px 28px;
                background: linear-gradient(180deg, #ffffff 0%, #f7faff 100%);
            }
            .update-brand {
                margin: 0;
                color: #153258;
                text-transform: uppercase;
                letter-spacing: 0.11em;
                font-weight: 800;
                font-size: 14px;
            }
            .update-aside-title {
                margin: 14px 0 10px;
                font-size: 26px;
                line-height: 1.2;
                color: var(--update-primary-deep);
            }
            .update-aside-copy {
                margin: 0;
                color: var(--update-muted);
                line-height: 1.7;
            }
            .update-checklist {
                margin: 22px 0 0;
                padding: 0;
                list-style: none;
            }
            .update-checklist li {
                position: relative;
                margin-bottom: 10px;
                padding-left: 24px;
                color: #435a7f;
                line-height: 1.55;
            }
            .update-checklist li::before {
                content: "";
                position: absolute;
                left: 0;
                top: 8px;
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: var(--update-primary);
            }
            .update-env {
                margin-top: 16px;
                padding-top: 16px;
                border-top: 1px dashed var(--update-border);
                color: #60739c;
                font-size: 13px;
                line-height: 1.5;
            }
            .update-alert {
                margin-bottom: 18px;
                padding: 12px 14px;
                border-radius: 10px;
                border: 1px solid transparent;
                font-size: 14px;
                line-height: 1.6;
            }
            .update-alert.success {
                color: #1d5c36;
                background: #edf9f2;
                border-color: #b9ebca;
            }
            .update-alert.error {
                color: #7c2130;
                background: #fff0f2;
                border-color: #f2c0c9;
            }
            .update-copy {
                margin: 0;
                color: var(--update-muted);
                font-size: 16px;
                line-height: 1.7;
            }
            .update-actions {
                margin-top: 26px;
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }
            .update-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 44px;
                padding: 0 18px;
                border-radius: 10px;
                text-decoration: none;
                font-size: 14px;
                font-weight: 700;
                border: 1px solid transparent;
                transition: all .2s ease;
            }
            .update-btn.primary {
                color: #fff;
                background: var(--update-primary);
                border-color: var(--update-primary);
            }
            .update-btn.primary:hover {
                filter: brightness(.94);
            }
            .update-btn.secondary {
                color: #2b4670;
                background: #fff;
                border-color: var(--update-border);
            }
            .update-btn.secondary:hover {
                border-color: var(--update-primary);
                color: var(--update-primary);
            }
            .update-stat {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                margin-top: 14px;
                padding: 12px 14px;
                border: 1px solid var(--update-border);
                border-radius: 12px;
                background: #f8fbff;
            }
            .update-stat-value {
                min-width: 40px;
                height: 40px;
                border-radius: 10px;
                background: var(--update-primary);
                color: #fff;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                font-weight: 800;
                line-height: 1;
            }
            .update-stat-label {
                color: #445c84;
                font-size: 14px;
                font-weight: 700;
                line-height: 1.4;
            }
            @media (max-width: 980px) {
                .update-shell {
                    padding: 38px 14px 24px;
                }
                .update-grid {
                    grid-template-columns: 1fr;
                }
                .update-main-head,
                .update-steps,
                .update-main-body {
                    padding-left: 20px;
                    padding-right: 20px;
                }
                .update-title {
                    font-size: 28px;
                }
            }
        </style>
        @yield('style')
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body class="update-body">
        <main class="update-shell">
            <section class="update-grid">
                <div class="update-card">
                    <div class="update-main-head">
                        <p class="update-badge">{{ trans('installer_messages.updater.title') }}</p>
                        <h1 class="update-title">@yield('title')</h1>
                        <p class="update-subtitle">{{ __('Run updates safely and keep your application stable with the latest database and package changes.') }}</p>
                    </div>
                    <div class="update-steps">
                        <div class="update-step {{ $is_welcome ? 'active' : '' }}">
                            <span class="update-step-index">1</span>
                            <span>{{ __('Welcome') }}</span>
                        </div>
                        <div class="update-step {{ $is_overview ? 'active' : '' }}">
                            <span class="update-step-index">2</span>
                            <span>{{ __('Overview') }}</span>
                        </div>
                        <div class="update-step {{ $is_final ? 'active' : '' }}">
                            <span class="update-step-index">3</span>
                            <span>{{ __('Complete') }}</span>
                        </div>
                    </div>
                    <div class="update-main-body">
                        @if (session('message'))
                            <div class="update-alert success">
                                @if (is_array(session('message')) && isset(session('message')['message']))
                                    {{ session('message')['message'] }}
                                @else
                                    {{ session('message') }}
                                @endif
                            </div>
                        @endif

                        @if (session()->has('errors') || $errors->any())
                            <div class="update-alert error">
                                @if (session()->has('errors'))
                                    @foreach (session('errors')->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                @else
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                        @yield('container')
                    </div>
                </div>

                <aside class="update-card update-aside">
                    <p class="update-brand">{{ $brand_name }}</p>
                    <h2 class="update-aside-title">{{ __('System Upgrade Console') }}</h2>
                    <p class="update-aside-copy">{{ __('Apply pending updates to keep modules, migrations, and workspace features running smoothly.') }}</p>
                    <ul class="update-checklist">
                        <li>{{ __('Review pending updates before running migrations.') }}</li>
                        <li>{{ __('Keep a fresh backup of your database and uploads.') }}</li>
                        <li>{{ __('Do not close this window while update tasks are running.') }}</li>
                    </ul>
                    <p class="update-env">
                        {{ __('Environment') }}: <strong>{{ app()->environment() }}</strong><br>
                        {{ __('Date') }}: <strong>{{ now()->format('Y-m-d H:i') }}</strong>
                    </p>
                </aside>
            </section>
        </main>
        @yield('scripts')
    </body>
</html>
