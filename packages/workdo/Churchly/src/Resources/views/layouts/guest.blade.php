<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module $STUDLY_NAME$</title>

       {{-- Laravel Vite - CSS File --}}
       {{-- {{ module_vite('build-$LOWER_NAME$', 'Resources/assets/sass/app.scss') }} --}}

    </head>
    <body>
        @php
    $company_settings = [];

    if (Auth::check()) {
        $creatorId = creatorId();
        $company_settings = getCompanyAllSetting($creatorId);
    }

    $color = $company_settings['color'] ?? 'theme-1';
    $themeColor = ($company_settings['color_flag'] ?? false) == 'true' ? 'custom-color' : $color;
@endphp


        @yield('content')

        {{-- Laravel Vite - JS File --}}
        {{-- {{ module_vite('build-$LOWER_NAME$', 'Resources/assets/js/app.js') }} --}}
    </body>
</html>
