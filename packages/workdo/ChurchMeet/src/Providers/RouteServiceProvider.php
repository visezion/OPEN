<?php

namespace Workdo\ChurchMeet\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Workdo\\ChurchMeet\\Http\\Controllers';

    public function map(): void
    {
        Route::middleware(['web', 'auth', 'verified'])
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/web.php');
    }
}
