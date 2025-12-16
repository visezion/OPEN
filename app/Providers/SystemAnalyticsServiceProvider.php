<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;

class SystemAnalyticsServiceProvider extends ServiceProvider
{
    public function boot(Router $router, ExceptionHandler $exceptions)
    {
        $router->pushMiddlewareToGroup('web', \App\Http\Middleware\TrackUsageMiddleware::class);

        $exceptions->reportable(function (\Throwable $e) {
            try {
                $request = request();
                DB::table('error_logs')->insert([
                    'user_id' => auth()->id(),
                    'workspace_id' => function_exists('getActiveWorkSpace') ? getActiveWorkSpace() : null,
                    'url' => $request ? $request->fullUrl() : null,
                    'route' => $request && $request->route() ? $request->route()->getName() : null,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'code' => $e->getCode(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Throwable $ignored) {
                //
            }
        });
    }

    public function register()
    {
        //
    }
}
