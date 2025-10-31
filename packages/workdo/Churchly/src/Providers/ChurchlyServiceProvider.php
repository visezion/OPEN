<?php

namespace Workdo\Churchly\Providers;

use Illuminate\Support\ServiceProvider;
use Workdo\Churchly\Providers\RouteServiceProvider;
use Workdo\Churchly\Providers\EventServiceProvider;

class ChurchlyServiceProvider extends ServiceProvider
{
    /**
     * Register Churchly module routes, events, and console commands.
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        // Register manual activation Artisan command
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Workdo\Churchly\Console\ChurchlyActivate::class,
                \Workdo\Churchly\Console\Commands\YouTubeSyncCommand::class,
                \Workdo\Churchly\Console\Commands\ZoomSyncCommand::class,
            ]);
        }
    }

    /**
     * Boot module resources: migrations, views, routes.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'churchly');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/api_v1.php');


        
        // Load global helper functions
        if (file_exists(__DIR__.'/../Helpers/helpers.php')) {
            require_once __DIR__.'/../Helpers/helpers.php';
        }

        // Schedule sync commands globally; per-workspace cadence enforced inside command
        $this->app->afterResolving(\Illuminate\Console\Scheduling\Schedule::class, function ($schedule) {
            $schedule->command('churchly:youtube-sync')->everyFiveMinutes();
            $schedule->command('churchly:zoom-sync')->everyFiveMinutes();
        });
    }
}



