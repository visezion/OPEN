<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('page-title', 'Church System')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('styles')
</head>
<body>
    <div class="container mt-5">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
