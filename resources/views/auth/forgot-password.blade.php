@extends('layouts.auth')
@section('page-title')
    {{ __('Reset Password') }}
@endsection

@section('language-bar')
    <li class="lang-dropdown-only-desk dropdown dash-h-item drp-language">
        <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="drp-text">{{ Str::upper($lang) }}</span>
        </a>
        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
            @foreach (languages() as $key => $language)
                <a href="{{ route('password.request', $key) }}"
                    class="dropdown-item @if ($lang == $key) text-primary @endif">
                    <span>{{ Str::ucfirst($language) }}</span>
                </a>
            @endforeach
        </div>
    </li>
@endsection

@php
    $admin_settings = getAdminAllSetting();
    $auth_brand = !empty($admin_settings['title_text']) ? $admin_settings['title_text'] : config('app.name', 'WorkDo');
@endphp

@section('content')
    <div class="dms-content-logo">
        <img src="{{ get_file(sidebar_logo()) }}{{ '?' . time() }}" alt="{{ config('app.name', 'WorkDo') }}">
    </div>

    <div class="dms-faith-layout">
        <section class="dms-faith-hero" aria-hidden="true">
            <div class="dms-hero-gradient"></div>
            <div class="dms-scene-grid"></div>
            <div class="dms-hero-brand">
                <span>{{ __('Admin Access') }}</span>
            </div>
            <div class="dms-hero-map">
                <div class="dms-radar-ring ring-a"></div>
                <div class="dms-radar-ring ring-b"></div>
                <div class="dms-radar-ring ring-c"></div>

                <svg class="dms-flow-svg" viewBox="0 0 1000 1000" preserveAspectRatio="none" fill="none">
                    <path class="dms-flow-line" d="M500 480 L190 190" />
                    <path class="dms-flow-line" d="M500 480 L300 760" />
                    <path class="dms-flow-line" d="M500 480 L760 180" />
                    <path class="dms-flow-line" d="M500 480 L840 360" />
                    <path class="dms-flow-line" d="M500 480 L820 700" />
                    <path class="dms-flow-line" d="M500 480 L430 145" />
                    <path class="dms-flow-line" d="M500 480 L650 815" />
                    <path class="dms-flow-line" d="M500 480 L120 520" />
                </svg>

                <div class="dms-node node-a">{{ __('Prayer Requests') }}</div>
                <div class="dms-node node-b">{{ __('Sunday Teams') }}</div>
                <div class="dms-node node-c">{{ __('Outreach Tasks') }}</div>
                <div class="dms-node node-d">{{ __('Policy Rules') }}</div>
                <div class="dms-node node-e">{{ __('Service Reports') }}</div>
                <div class="dms-node node-f">{{ __('Discipleship') }}</div>
                <div class="dms-node dms-node-tag node-g">Testimonies</div>
                <div class="dms-node dms-node-tag node-h">Finances</div>

                <div class="dms-core">
                    <p>{{ __('Control Plane') }}</p>
                    <h3>{{ $auth_brand }}</h3>
                    <small>{{ __('In Christ Jesus') }}</small>
                </div>
            </div>
            <div class="dms-hero-copy">
                <p class="dms-hero-label">{{ __('Faith Control Network') }}</p>
                <h2>{{ __('Secure account recovery with your registered email') }}</h2>
                <p>{{ __('Request a reset link and continue managing your ministry workspace safely.') }}</p>
            </div>
        </section>

        <section class="dms-faith-form-zone">
            <div class="dms-faith-card">
                <div class="dms-card-head">
                    <div>
                        <p class="dms-card-label">{{ __('Password Recovery') }}</p>
                        <h2>{{ $auth_brand }}</h2>
                        <p class="dms-card-copy">{{ __('Enter your account email to receive a secure reset link') }}</p>
                    </div>
                    <div class="dms-card-icon" aria-hidden="true">&#10013;</div>
                </div>

                @if (session('status'))
                    <div class="alert alert-success mb-3">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="dms-error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" id="forgot_password_form"
                    class="needs-validation dms-login-form" novalidate="" autocomplete="off">
                    @csrf
                    <div class="dms-form-group">
                        <label class="dms-label" for="email">{{ __('Email') }}</label>
                        <div class="dms-field-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                    <path d="m4 7 8 6 8-6"></path>
                                </svg>
                            </span>
                            <input id="email" type="email"
                                class="form-control dms-login-input @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" placeholder="{{ __('Enter your email') }}" required autofocus
                                autocapitalize="off" spellcheck="false">
                        </div>
                        @error('email')
                            <span class="error invalid-email text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>

                    @stack('recaptcha_field')

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary forgot_button dms-submit-btn">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>

                    <p class="dms-register">{{ __('Remembered your password?') }}
                        <a href="{{ route('login', $lang) }}">{{ __('Back to login') }}</a>
                    </p>
                    <p class="dms-note">{{ __('This app is free and open source, built to help your team grow with confidence.') }}</p>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            document.body.classList.add("faith-login-page", "dms-faith-login");

            $("#forgot_password_form").submit(function() {
                const button = $(".forgot_button");
                button.attr("disabled", true).addClass("disabled");
                setTimeout(() => {
                    button.attr("disabled", false).removeClass("disabled");
                }, 1500);
            });
        });
    </script>
@endpush
