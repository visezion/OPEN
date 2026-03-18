@extends('layouts.main')
@section('page-title')
    {{ __('Dashboard') }}
@endsection

@push('css')
    <style>
        .superadmin-dashboard-page .dash-sidebar,
        .superadmin-dashboard-page .dash-header,
        .superadmin-dashboard-page .page-header,
        .superadmin-dashboard-page .sa-dashboard .card,
        .superadmin-dashboard-page .sa-dashboard .sa-hero-card,
        .superadmin-dashboard-page .sa-dashboard .sa-kpi-card,
        .superadmin-dashboard-page .sa-dashboard .sa-detail-card,
        .superadmin-dashboard-page .sa-dashboard .sa-chart-card,
        .superadmin-dashboard-page .qr-card,
        .superadmin-dashboard-page .qr-card-inner {
            box-shadow: none !important;
            filter: none !important;
        }
        .superadmin-dashboard-page .dash-sidebar.superadmin-sidebar {
            border-right: 1px solid #d7dfeb;
            background: #ffffff;
        }
        .superadmin-dashboard-page .dash-sidebar .main-logo {
            padding: 20px 18px 10px;
        }
        .superadmin-dashboard-page .dash-sidebar .sidebar-search {
            padding-top: 8px;
            padding-bottom: 12px;
        }
        .superadmin-dashboard-page .dash-sidebar .search-container input {
            border: 1px solid #d6e0ee;
            background: #ffffff;
            border-radius: 12px;
        }
        .superadmin-dashboard-page .dash-sidebar .dash-navbar > .dash-item > .dash-link {
            margin: 4px 10px;
            padding: 10px 12px;
            border-radius: 12px;
            transition: all .2s ease;
        }
        .superadmin-dashboard-page .dash-sidebar .dash-navbar > .dash-item.active > .dash-link,
        .superadmin-dashboard-page .dash-sidebar .dash-navbar > .dash-item:hover > .dash-link {
            background: #ffffff;
        }
        .superadmin-dashboard-page .dash-sidebar .dash-navbar > .dash-item.active > .dash-link .dash-mtext,
        .superadmin-dashboard-page .dash-sidebar .dash-navbar > .dash-item.active > .dash-link i {
            color: var(--bs-primary);
        }

        .sa-dashboard .sa-hero-card {
            position: relative;
            overflow: hidden;
            border: 1px solid #d8e1ef;
            border-radius: 18px;
            background: #ffffff;
        }
        .sa-dashboard .sa-hero-card .card-body {
            padding: 28px;
        }
        .sa-dashboard .sa-hero-badge {
            margin: 0;
            color: var(--bs-primary);
            letter-spacing: .1em;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 12px;
        }
        .sa-dashboard .sa-hero-title {
            margin: 8px 0 10px;
            font-size: 30px;
            line-height: 1.2;
            color: #162b4b;
            font-weight: 700;
        }
        .sa-dashboard .sa-hero-desc {
            margin: 0;
            color: #5f7395;
            max-width: 780px;
            line-height: 1.7;
        }
        .sa-dashboard .sa-action-row {
            margin-top: 20px;
        }
        .sa-dashboard .sa-copy-btn {
            border: 1px solid #cfdbee;
            color: #21406f;
            background: #fff;
        }
        .sa-dashboard .sa-copy-btn:hover {
            border-color: var(--bs-primary);
            color: var(--bs-primary);
            background: #fff;
        }

        .sa-dashboard .sa-kpi-card,
        .sa-dashboard .sa-detail-card,
        .sa-dashboard .sa-chart-card {
            border: 1px solid #dde5f1;
            border-radius: 16px;
            background: #fff;
        }
        .sa-dashboard .sa-kpi-card {
            position: relative;
            overflow: hidden;
            background: #ffffff;
        }
        .sa-dashboard .sa-kpi-card::before {
            content: "";
            position: absolute;
            inset: 0 auto auto 0;
            width: 100%;
            height: 3px;
            background: #a2b7d7;
        }
        .sa-dashboard .sa-kpi-card .card-body {
            padding: 18px 18px 16px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .sa-dashboard .sa-kpi-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .sa-dashboard .sa-kpi-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            background: #ffffff;
            color: #204a80;
            border: 1px solid #cfddf1;
        }
        .sa-dashboard .sa-kpi-meta {
            margin: 0;
            color: #7890b3;
            font-size: 11px;
            letter-spacing: .06em;
            text-transform: uppercase;
            font-weight: 700;
        }
        .sa-dashboard .sa-kpi-label {
            margin: 0;
            color: #617693;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 700;
        }
        .sa-dashboard .sa-kpi-value {
            margin: 10px 0 0;
            color: #10274a;
            font-size: 34px;
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -.02em;
        }
        .sa-dashboard .sa-kpi-link {
            margin-top: auto;
            display: inline-flex;
            gap: 6px;
            align-items: center;
            color: var(--bs-primary);
            font-size: 13px;
            text-decoration: none;
            font-weight: 600;
            padding-top: 14px;
        }
        .sa-dashboard .sa-kpi-link i {
            font-size: 14px;
        }
        .sa-dashboard .sa-kpi-card.kpi-customers::before {
            background: #2f5f98;
        }
        .sa-dashboard .sa-kpi-card.kpi-paid::before {
            background: #2d8f60;
        }
        .sa-dashboard .sa-kpi-card.kpi-orders::before {
            background: #8a57c5;
        }
        .sa-dashboard .sa-kpi-card.kpi-plans::before {
            background: #c28722;
        }
        .sa-dashboard .sa-detail-card .card-body {
            padding: 22px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .sa-dashboard .sa-detail-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .sa-dashboard .sa-detail-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            background: #ffffff;
            border: 1px solid #cfddf1;
            color: #204a80;
        }
        .sa-dashboard .sa-detail-title {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #6a7f9f;
            font-weight: 700;
        }
        .sa-dashboard .sa-detail-value {
            margin: 10px 0 0;
            color: #12294b;
            font-size: 30px;
            font-weight: 700;
            line-height: 1.15;
            letter-spacing: -.02em;
        }
        .sa-dashboard .sa-detail-sub {
            margin: 4px 0 0;
            color: #6f84a3;
            font-size: 13px;
        }
        .sa-dashboard .sa-detail-note {
            margin: 2px 0 0;
            color: #5a7092;
            font-size: 13px;
            font-weight: 600;
        }
        .sa-dashboard .sa-chart-card .card-header {
            padding: 18px 22px 0;
            background: transparent;
            border: 0;
        }
        .sa-dashboard .sa-chart-title {
            margin: 0;
            font-size: 20px;
            color: #112a4d;
            font-weight: 700;
        }
        .sa-dashboard .sa-chart-subtitle {
            margin: 4px 0 0;
            color: #637998;
            font-size: 13px;
        }
        .sa-dashboard .sa-chart-card .card-body {
            padding: 6px 10px 12px;
        }
        .sa-dashboard .sharingButtonsContainer {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            z-index: 6;
        }
        [dir="rtl"] .sa-dashboard .sharingButtonsContainer {
            left: auto;
            right: 0;
        }
        @media (max-width: 1199px) {
            .sa-dashboard .sa-hero-title {
                font-size: 26px;
            }
        }
        @media (max-width: 767px) {
            .sa-dashboard .sa-hero-card .card-body {
                padding: 20px;
            }
            .sa-dashboard .sa-hero-title {
                font-size: 22px;
            }
            .sa-dashboard .sa-kpi-value {
                font-size: 24px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script>
        (function() {
            const css = getComputedStyle(document.documentElement);
            const primary = (css.getPropertyValue('--bs-primary') || css.getPropertyValue('--theme-color') || '#145388').trim();
            const labels = {!! json_encode($chartData['label']) !!};
            const values = {!! json_encode($chartData['data']) !!};

            const chartBarOptions = {
                series: [{
                    name: '{{ __('Order') }}',
                    data: values,
                }],
                chart: {
                    height: 340,
                    type: 'area',
                    toolbar: {
                        show: false
                    },
                    dropShadow: {
                        enabled: false,
                        color: primary,
                        top: 14,
                        left: 3,
                        blur: 8,
                        opacity: 0.12
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2.4,
                    curve: 'smooth'
                },
                xaxis: {
                    categories: labels,
                    title: {
                        text: '{{ __('Days') }}'
                    }
                },
                yaxis: {
                    title: {
                        text: '{{ __('Order') }}'
                    }
                },
                colors: [primary],
                fill: {
                    type: 'solid',
                    opacity: 0.12
                },
                grid: {
                    strokeDashArray: 4,
                    borderColor: '#dbe4f2'
                },
                legend: {
                    show: false
                }
            };

            const chartTarget = document.querySelector("#chart-sales");
            if (chartTarget) {
                const arChart = new ApexCharts(chartTarget, chartBarOptions);
                arChart.render();
            }
        })();

        (function() {
            document.querySelectorAll('.cp_link').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const value = btn.getAttribute('data-link');
                    if (!value) {
                        return;
                    }
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(value);
                    } else {
                        const temp = document.createElement('input');
                        temp.value = value;
                        document.body.appendChild(temp);
                        temp.select();
                        document.execCommand('copy');
                        document.body.removeChild(temp);
                    }
                    if (typeof toastrs === 'function') {
                        toastrs('{{ __('Success') }}', '{{ __('Link copied to clipboard') }}', 'success');
                    }
                });
            });
        })();
    </script>
@endpush

@section('content')
    @php
        $popular_plan_name = !empty($user->popular_plan) ? $user->popular_plan->name : __('No popular plan yet');
    @endphp
    <div class="sa-dashboard">
        <div class="row g-3 mb-4">
            <div class="{{ module_is_active('LandingPage') ? 'col-xxl-9 col-12' : 'col-12' }}">
                <div class="card sa-hero-card">
                    <div class="card-body">
                        <p class="sa-hero-badge">{{ __('Super Admin Console') }}</p>
                        <h2 class="sa-hero-title">{{ __('Welcome back, :name', ['name' => auth()->user()->name]) }}</h2>
                        <p class="sa-hero-desc">{{ __('Manage customers, plans, and orders from one centralized dashboard with clear visibility and fast actions.') }}</p>
                        <div class="d-flex flex-wrap gap-2 align-items-center sa-action-row position-relative">
                            <a href="{{ route('users.index') }}" class="btn btn-primary">
                                <i class="ti ti-users me-1"></i>{{ __('Manage Customers') }}
                            </a>
                            <a href="{{ route('plan.order.index') }}" class="btn btn-outline-primary">
                                <i class="ti ti-receipt-2 me-1"></i>{{ __('View Orders') }}
                            </a>
                            <a href="javascript:void(0);" class="btn sa-copy-btn cp_link" data-link="{{ url('/') }}">
                                <i class="ti ti-link me-1"></i>{{ __('Copy Site Link') }}
                            </a>
                            @if (module_is_active('LandingPage'))
                                <a href="javascript:void(0);" class="btn btn-outline-primary socialShareButton" id="socialShareButton">
                                    <i class="ti ti-share me-1"></i>{{ __('Share') }}
                                </a>
                            @endif
                            <div id="sharingButtonsContainer" class="sharingButtonsContainer" style="display: none;">
                                <div class="Demo1 d-flex align-items-center gap-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (module_is_active('LandingPage'))
                @include('landingpage::layouts.dash_qr')
            @endif
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card sa-kpi-card kpi-customers h-100">
                    <div class="card-body">
                        <div class="sa-kpi-head">
                            <p class="sa-kpi-label">{{ __('Total Customers') }}</p>
                            <span class="sa-kpi-icon"><i class="ti ti-users"></i></span>
                        </div>
                        <p class="sa-kpi-meta">{{ __('All registered companies') }}</p>
                        <h3 class="sa-kpi-value">{{ number_format((int) $user->total_user) }}</h3>
                        <a href="{{ route('users.index') }}" class="sa-kpi-link">{{ __('Open customers') }} <i class="ti ti-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card sa-kpi-card kpi-paid h-100">
                    <div class="card-body">
                        <div class="sa-kpi-head">
                            <p class="sa-kpi-label">{{ __('Paid Customers') }}</p>
                            <span class="sa-kpi-icon"><i class="ti ti-user-check"></i></span>
                        </div>
                        <p class="sa-kpi-meta">{{ __('Active paying customers') }}</p>
                        <h3 class="sa-kpi-value">{{ number_format((int) $user['total_paid_user']) }}</h3>
                        <a href="{{ route('users.index') }}" class="sa-kpi-link">{{ __('View details') }} <i class="ti ti-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card sa-kpi-card kpi-orders h-100">
                    <div class="card-body">
                        <div class="sa-kpi-head">
                            <p class="sa-kpi-label">{{ __('Total Orders') }}</p>
                            <span class="sa-kpi-icon"><i class="ti ti-shopping-cart"></i></span>
                        </div>
                        <p class="sa-kpi-meta">{{ __('Plan and add-on orders') }}</p>
                        <h3 class="sa-kpi-value">{{ number_format((int) $user->total_orders) }}</h3>
                        <a href="{{ route('plan.order.index') }}" class="sa-kpi-link">{{ __('Open orders') }} <i class="ti ti-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card sa-kpi-card kpi-plans h-100">
                    <div class="card-body">
                        <div class="sa-kpi-head">
                            <p class="sa-kpi-label">{{ __('Total Plans') }}</p>
                            <span class="sa-kpi-icon"><i class="ti ti-stack-2"></i></span>
                        </div>
                        <p class="sa-kpi-meta">{{ __('Available subscription plans') }}</p>
                        <h3 class="sa-kpi-value">{{ number_format((int) $user->total_plans) }}</h3>
                        <a href="{{ route('plan.list') }}" class="sa-kpi-link">{{ __('Open plans') }} <i class="ti ti-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-7">
                <div class="card sa-detail-card h-100">
                    <div class="card-body">
                        <div class="sa-detail-head">
                            <div>
                                <p class="sa-detail-title">{{ __('Total Order Amount') }}</p>
                                <p class="sa-detail-sub">{{ __('Across all completed and active orders') }}</p>
                            </div>
                            <span class="sa-detail-icon"><i class="ti ti-currency-dollar"></i></span>
                        </div>
                        <h3 class="sa-detail-value">{{ super_currency_format_with_sym($user['total_orders_price']) }}</h3>
                        <p class="sa-detail-note">{{ __('Revenue snapshot') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="card sa-detail-card h-100">
                    <div class="card-body">
                        <div class="sa-detail-head">
                            <div>
                                <p class="sa-detail-title">{{ __('Most Popular Plan') }}</p>
                                <p class="sa-detail-sub">{{ __('Top selected plan by customers') }}</p>
                            </div>
                            <span class="sa-detail-icon"><i class="ti ti-trophy"></i></span>
                        </div>
                        <h3 class="sa-detail-value">{{ $popular_plan_name }}</h3>
                        <p class="sa-detail-note">{{ __('Best performer this period') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card sa-chart-card">
                    <div class="card-header">
                        <h4 class="sa-chart-title">{{ __('Recent Orders') }}</h4>
                        <p class="sa-chart-subtitle">{{ __('Last 14 days order activity overview') }}</p>
                    </div>
                    <div class="card-body">
                        <div id="chart-sales" data-color="primary" data-height="340"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (module_is_active('LandingPage'))
    @include('landingpage::layouts.dash_qr_scripts')
@endif
