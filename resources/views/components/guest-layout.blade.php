@props(['workspace' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $workspace?->name ? $workspace->name.' - ' : '' }}{{ __('Church Portal') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ui-clean.css') }}">
</head>
<body class="theme-1 ui-border-clean">
    <div class="min-vh-100 d-flex align-items-center py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="card border-0 shadow-sm overflow-hidden">
                        <div class="card-body p-0">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
