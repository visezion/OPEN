@extends('layouts.auth')
@section('page-title')
    {{ __('Register') }}
@endsection
@section('language-bar')
    <li class="lang-dropdown-only-desk dropdown dash-h-item drp-language">
        <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="drp-text"> {{ Str::upper($lang) }}
            </span>
        </a>
        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
            @foreach (languages() as $key => $language)
                <a href="{{ route('register', ['lang' => $key, 'ref_id' => $ref]) }}"
                    class="dropdown-item @if ($lang == $key) text-primary @endif">
                    <span>{{ Str::ucfirst($language) }}</span>
                </a>
            @endforeach
        </div>
    </li>
@endsection
@php
    $admin_settings = getAdminAllSetting();
    $setting = Workdo\LandingPage\Entities\LandingPageSetting::settings();
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
                <h2>{{ __('Centralized ministry operations in Christ Jesus') }}</h2>
                <p>{{ __('Prayer, service teams, outreach tasks, and reports from one trusted portal.') }}</p>
            </div>
        </section>

        <section class="dms-faith-form-zone">
            <div class="dms-faith-card">
                <div class="dms-card-head">
                    <div>
                        <p class="dms-card-label">{{ __('Ministry Admin Register') }}</p>
                        <h2>{{ $auth_brand }}</h2>
                        <p class="dms-card-copy">{{ __('Create your ministry workspace account') }}</p>
                    </div>
                    <div class="dms-card-icon" aria-hidden="true">&#10013;</div>
                </div>

                @if ($errors->any())
                    <div class="dms-error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="needs-validation dms-login-form"
                    novalidate="" id="register_form_data" autocomplete="off">
                    @csrf

                    <div class="dms-form-group">
                        <label class="dms-label" for="name">{{ __('Name') }}</label>
                        <div class="dms-field-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M20 21a8 8 0 1 0-16 0"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input id="name" type="text" class="form-control dms-login-input @error('name') is-invalid @enderror"
                                name="name" placeholder="{{ __('Enter name') }}" value="{{ old('name') }}" required
                                autocomplete="name" autofocus>
                        </div>
                        @error('name')
                            <span class="error invalid-name text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>

                    <div class="dms-form-group">
                        <label class="dms-label" for="store_name">{{ __('WorkSpace Name') }}</label>
                        <div class="dms-field-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                                    <path d="M3 9h18"></path>
                                </svg>
                            </span>
                            <input id="store_name" type="text"
                                class="form-control dms-login-input @error('workspace') is-invalid @enderror"
                                name="workspace" placeholder="{{ __('Enter workspace name') }}"
                                value="{{ old('workspace') }}" required autocomplete="organization">
                        </div>
                        @error('workspace')
                            <span class="error invalid-workspace text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>

                    <input type="hidden" name="type" value="register" id="type">

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
                                placeholder="{{ __('Enter your email') }}" value="{{ old('email') }}" required
                                autocapitalize="off" spellcheck="false">
                        </div>
                        @error('email')
                            <span class="error invalid-email text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>

                    <div class="dms-form-group">
                        <label class="dms-label" for="register-password">{{ __('Password') }}</label>
                        <div class="dms-field-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                                    <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                                </svg>
                            </span>
                            <input id="register-password" type="password"
                                class="form-control dms-login-input @error('password') is-invalid @enderror"
                                name="password" placeholder="{{ __('Enter your password') }}" required
                                autocomplete="new-password">
                            <button type="button" id="toggle-register-password" class="dms-toggle-pass"
                                aria-label="{{ __('Show password') }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="error invalid-password text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>

                    <div class="dms-form-group">
                        <label class="dms-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                        <div class="dms-field-wrap">
                            <span class="dms-field-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                                    <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                                </svg>
                            </span>
                            <input id="password-confirm" type="password"
                                class="form-control dms-login-input @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" placeholder="{{ __('Confirm your password') }}" required
                                autocomplete="new-password">
                            <button type="button" id="toggle-confirm-password" class="dms-toggle-pass"
                                aria-label="{{ __('Show password') }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="error invalid-password-confirm text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>

                    <div class="dms-login-actions">
                        <label class="form-check dms-remember mb-0" for="termsCheckbox">
                            <input type="checkbox" class="form-check-input" id="termsCheckbox" name="terms" required>
                            <span class="form-check-label">
                                {{ __('I agree to the') }}
                                @if (is_array(json_decode($setting['menubar_page'])) || is_object(json_decode($setting['menubar_page'])))
                                    @foreach (json_decode($setting['menubar_page']) as $value)
                                        @if (in_array($value->page_slug, ['terms_and_conditions']) && isset($value->template_name))
                                            @if (module_is_active('LandingPage'))
                                                <a href="{{ $value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url }}"
                                                    target="_blank">{{ $value->menubar_page_name }}</a>
                                            @else
                                                <a href="{{ route('custompage', ['page' => 'terms_and_conditions']) }}"
                                                    target="_blank">{{ __('Terms and Conditions') }}</a>
                                            @endif
                                        @endif
                                    @endforeach
                                    {{ __('and the') }}
                                    @foreach (json_decode($setting['menubar_page']) as $value)
                                        @if (in_array($value->page_slug, ['privacy_policy']) && isset($value->template_name))
                                            @if (module_is_active('LandingPage'))
                                                <a href="{{ $value->template_name == 'page_content' ? route('custom.page', $value->page_slug) : $value->page_url }}"
                                                    target="_blank">{{ $value->menubar_page_name }}</a>
                                            @else
                                                <a href="{{ route('custompage', ['page' => 'privacy_policy']) }}"
                                                    target="_blank">{{ __('Privacy Policy') }}</a>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                            </span>
                        </label>
                    </div>

                    @stack('recaptcha_field')
                    <input type="hidden" name="ref_code" value="{{ $ref }}">

                    <div class="d-grid">
                        <button class="btn btn-primary btn-block mt-2 register_button dms-submit-btn" type="submit">
                            {{ __('Create Account') }}
                        </button>
                        @stack('SigninButton')
                    </div>

                    <p class="dms-register">{{ __('Already have an account?') }}
                        <a href="{{ route('login', $lang) }}">{{ __('Sign in') }}</a>
                    </p>
                    <p class="dms-note">{{ __('Authorized ministry users only. Activity is monitored for accountability in Christ.') }}</p>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            document.body.classList.add("faith-login-page", "dms-faith-login");

            function bindToggle(buttonId, inputId) {
                const button = document.getElementById(buttonId);
                const input = document.getElementById(inputId);
                if (!button || !input) {
                    return;
                }
                button.addEventListener("click", function() {
                    const isPassword = input.type === "password";
                    input.type = isPassword ? "text" : "password";
                    button.setAttribute("aria-label", isPassword ? "Hide password" : "Show password");
                });
            }

            bindToggle("toggle-register-password", "register-password");
            bindToggle("toggle-confirm-password", "password-confirm");

            $("#register_form_data").submit(function() {
                const button = $(".register_button");
                button.attr("disabled", true).addClass("disabled");
                setTimeout(() => {
                    button.attr("disabled", false).removeClass("disabled");
                }, 1500);
            });
        });
    </script>
@endpush
