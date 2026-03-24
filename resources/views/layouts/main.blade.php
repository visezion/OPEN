@php
    $admin_settings = getAdminAllSetting();

    $company_settings = getCompanyAllSetting(creatorId());

    $color = !empty($company_settings['color']) ? $company_settings['color'] : 'theme-1';
      if (isset($company_settings['color_flag']) && $company_settings['color_flag'] == 'true') {
          $themeColor = 'custom-color';
      } else {
          $themeColor = $color;
      }

      $is_dashboard_route = request()->routeIs('dashboard');
      $is_superadmin_user = Auth::check() && Auth::user()->type === 'super admin';
      $is_superadmin_dashboard = $is_superadmin_user && $is_dashboard_route;
      $current_route_action = optional(request()->route())->getActionName();
      $is_churchly_route = is_string($current_route_action) && str_contains($current_route_action, 'Workdo\\Churchly\\');
      $is_churchmeet_route = is_string($current_route_action) && str_contains($current_route_action, 'Workdo\\ChurchMeet\\');
      $body_classes = trim(
          (isset($themeColor) ? $themeColor : 'theme-1')
          . ($is_superadmin_user ? ' superadmin-page' : '')
          . ($is_superadmin_dashboard ? ' superadmin-dashboard-page' : '')
          . ($is_churchly_route ? ' churchly-module-page' : '')
          . ($is_churchmeet_route ? ' churchmeet-module-page' : '')
      );
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ isset($company_settings['site_rtl']) && $company_settings['site_rtl'] == 'on' ? 'rtl' : '' }}">
@include('partials.head')
<body class="{{ $body_classes }} ui-border-clean">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill">

            </div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ auth-signup ] end -->
    @include('partials.sidebar')
    @include('partials.header')
    
    <section class="dash-container">
        <div class="dash-content">
            <!-- [ breadcrumb ] start -->
            @if (!$is_dashboard_route)
                <div class="page-header">
                    <div class="page-block">
                        <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between">
                            <div>
                                <div class="page-header-title">
                                    <h4 class="mb-2">@yield('page-title')</h4>
                                </div>
                                <ul class="breadcrumb">
                                    @php
                                        if (isset(app()->view->getSections()['page-breadcrumb'])) {
                                            $breadcrumb = explode(',', app()->view->getSections()['page-breadcrumb']);
                                        } else {
                                            $breadcrumb = [];
                                        }
                                    @endphp
                                    @if (!empty($breadcrumb))
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                                        @foreach ($breadcrumb as $item)
                                            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                                                {{ $item }}</li>
                                        @endforeach
                                    @endif

                                </ul>
                                
                            </div>
                            <div>
                                @yield('page-action')
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            @yield('content')
        </div>
    </section>
@include('partials.footer')
