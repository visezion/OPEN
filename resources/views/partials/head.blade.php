@php
    $favicon = isset($company_settings['favicon']) ? $company_settings['favicon'] : (isset($admin_settings['favicon']) ? $admin_settings['favicon'] : 'uploads/logo/favicon.png');
@endphp
<head>

    <title>@yield('page-title') | {{ !empty($company_settings['title_text']) ? $company_settings['title_text'] : (!empty($admin_settings['title_text']) ? $admin_settings['title_text'] :'WorkDo') }}
    </title>

    <meta name="title" content="{{ !empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash' }}">
    <meta name="keywords" content="{{ !empty($admin_settings['meta_keywords']) ? $admin_settings['meta_keywords'] : 'WorkDo Dash,SaaS solution,Multi-workspace' }}">
    <meta name="description" content="{{ !empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'}}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ !empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash' }}">
    <meta property="og:description" content="{{ !empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'}} ">
    <meta property="og:image" content="{{ get_file( (!empty($admin_settings['meta_image'])) ? (check_file($admin_settings['meta_image'])) ?  $admin_settings['meta_image'] : 'uploads/meta/meta_image.png' : 'uploads/meta/meta_image.png'  ) }}{{'?'.time() }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ !empty($admin_settings['meta_title']) ? $admin_settings['meta_title'] : 'WOrkdo Dash' }}">
    <meta property="twitter:description" content="{{ !empty($admin_settings['meta_description']) ? $admin_settings['meta_description'] : 'Discover the efficiency of Dash, a user-friendly web application by WorkDo.'}} ">
    <meta property="twitter:image" content="{{ get_file( (!empty($admin_settings['meta_image'])) ? (check_file($admin_settings['meta_image'])) ?  $admin_settings['meta_image'] : 'uploads/meta/meta_image.png' : 'uploads/meta/meta_image.png'  ) }}{{'?'.time() }}">

    <meta name="author" content="Workdo.io">

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('').'/'.config('chatify.routes.prefix') }}" data-user="{{ optional(Auth::user())->id ?? 0 }}">

    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> --}}

    <!-- Favicon icon -->
    <link rel="icon" href="{{ check_file($favicon) ? get_file($favicon) : get_file('uploads/logo/favicon.png')  }}{{'?'.time()}}" type="image/x-icon" />

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css')}}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/plugins/bootstrap-switch-button.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datepicker-bs5.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}" >
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custome.css') }}">
    <style>
        :root {
            --color-customColor: <?= $color ?>;
        }

        body,
        .dash-container,
        .dash-content {
            background: #ffffff !important;
        }

        .dash-header {
            border-bottom: 1px solid #d8e2ef !important;
            box-shadow: none !important;
        }

        .dash-sidebar {
            border-right: 1px solid #d8e2ef !important;
            box-shadow: none !important;
            background: #ffffff !important;
        }

        [dir="rtl"] .dash-sidebar {
            border-right: 0 !important;
            border-left: 1px solid #d8e2ef !important;
        }

        .dash-content .page-header {
            border-bottom: 1px solid #d8e2ef !important;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }

        body:not(.minimenu) .dash-sidebar.light-sidebar .dash-navbar > .dash-item > .dash-link {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            margin: 4px 10px !important;
            padding: 10px 12px !important;
            border-radius: 12px !important;
            box-shadow: none !important;
        }

        body:not(.minimenu) .dash-sidebar.light-sidebar .dash-link .dash-micon {
            margin-right: 0 !important;
            flex: 0 0 34px !important;
            width: 34px !important;
            height: 34px !important;
            box-shadow: none !important;
        }

        body:not(.minimenu) .dash-sidebar.light-sidebar .dash-link .dash-mtext {
            display: block !important;
            flex: 1 1 auto !important;
            min-width: 0 !important;
            line-height: 1.2 !important;
            color: #000000 !important;
        }

        body:not(.minimenu) .dash-sidebar.light-sidebar .dash-navbar > .dash-item.active > .dash-link,
        body:not(.minimenu) .dash-sidebar.light-sidebar .dash-navbar > .dash-item:hover > .dash-link {
            border: 1px solid #d8e2ef;
            background: #ffffff !important;
        }

        .superadmin-page .dash-header,
        .superadmin-page .dash-sidebar,
        .superadmin-page .page-header,
        .superadmin-page .card,
        .superadmin-page .dropdown-menu,
        .superadmin-page .modal-content,
        .superadmin-page .table-responsive,
        .superadmin-page .accordion-item,
        .superadmin-page .nav-pills .nav-link,
        .superadmin-page .list-group-item,
        .superadmin-page .form-control,
        .superadmin-page .form-select,
        .superadmin-page .select2-container--default .select2-selection--single,
        .superadmin-page .select2-container--default .select2-selection--multiple {
            box-shadow: none !important;
            filter: none !important;
        }

        .superadmin-page .dash-header,
        .superadmin-page .dash-sidebar,
        .superadmin-page .page-header,
        .superadmin-page .card,
        .superadmin-page .dropdown-menu,
        .superadmin-page .modal-content,
        .superadmin-page .table-responsive,
        .superadmin-page .accordion-item,
        .superadmin-page .list-group-item,
        .superadmin-page .form-control,
        .superadmin-page .form-select,
        .superadmin-page .select2-container--default .select2-selection--single,
        .superadmin-page .select2-container--default .select2-selection--multiple {
            border-color: #d8e2ef !important;
        }

        .superadmin-page .dash-sidebar.light-sidebar .dash-link .dash-micon {
            box-shadow: none !important;
            border: 1px solid #d8e2ef !important;
            background: #ffffff !important;
        }

        .superadmin-page .dash-sidebar.light-sidebar .dash-navbar > .dash-item.active > .dash-link,
        .superadmin-page .dash-sidebar.light-sidebar .dash-navbar > .dash-item:hover > .dash-link {
            box-shadow: none !important;
            border: 1px solid #d8e2ef !important;
            background: #ffffff !important;
        }

        .superadmin-page .dash-sidebar.light-sidebar .dash-submenu {
            box-shadow: none !important;
            border: 1px solid #d8e2ef !important;
        }

        .dash-sidebar .dash-link,
        .dash-sidebar .dash-link .dash-mtext,
        .dash-sidebar .dash-link .dash-arrow,
        .dash-sidebar .dash-caption label,
        .dash-sidebar .dash-caption span:not(.badge) {
            color: #000000 !important;
        }

        .superadmin-page .card-header {
            border-bottom: 1px solid #d8e2ef !important;
            background: #ffffff !important;
        }

        .superadmin-page .card-footer {
            border-top: 1px solid #d8e2ef !important;
            background: #ffffff !important;
        }

        .superadmin-page .table > :not(caption) > * > * {
            border-color: #d8e2ef !important;
        }

        .superadmin-page .table-responsive {
            border: 1px solid #d8e2ef !important;
            border-radius: 12px;
            background: #ffffff !important;
        }

        .superadmin-page .table {
            margin-bottom: 0 !important;
            background: #ffffff !important;
        }

        .superadmin-page .table > :not(caption) > * > * {
            border-style: solid !important;
            border-width: 0 1px 1px 0 !important;
            border-color: #d8e2ef !important;
        }

        .superadmin-page .table > :not(caption) > * > *:last-child {
            border-right: 0 !important;
        }

        .superadmin-page .table > thead > tr > * {
            background: #f8fbff !important;
            border-bottom: 1px solid #d8e2ef !important;
        }

        .superadmin-page .table > tbody > tr:last-child > * {
            border-bottom: 0 !important;
        }

        .superadmin-page .dropdown-divider,
        .superadmin-page .list-group-item + .list-group-item,
        .superadmin-page .accordion-button {
            border-color: #d8e2ef !important;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/custom-color.css') }}">
    @if ((isset($company_settings['site_rtl']) ? $company_settings['site_rtl'] : 'off')== 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}">
    @endif

    @if ((isset($company_settings['cust_darklayout']) ? $company_settings['cust_darklayout'] : 'off') == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style-link">
    @endif
    @if ((isset($company_settings['site_rtl']) ? $company_settings['site_rtl'] : 'off' )!= 'on' && (isset($company_settings['cust_darklayout']) ? $company_settings['cust_darklayout'] : 'off') != 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @else
        <link rel="stylesheet" href="" id="main-style-link">
    @endif
    <link rel="stylesheet" href="{{ asset('css/ui-clean.css') }}">

    @stack('css')
    @stack('availabilitylink')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/nprogress.css') }}">
    <script src="{{ asset('assets/js/nprogress.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>
