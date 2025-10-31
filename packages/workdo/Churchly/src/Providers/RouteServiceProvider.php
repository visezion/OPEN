<?php

namespace Workdo\Churchly\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Workdo\\Churchly\\Http\\Controllers';

    public function map()
    {
        // Authenticated web routes
        Route::middleware(['web', 'auth', 'verified'])
            ->namespace($this->namespace)
            ->group(__DIR__.'/../Routes/web.php');

        // Public routes (no auth)
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__.'/../Routes/public.php');

        // API routes are already self-prefixed inside the route file
        Route::middleware('api')
            ->group(__DIR__.'/../Routes/api_v1.php');
    }
}

