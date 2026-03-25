<?php

namespace Workdo\ChurchMeet\Providers;

use Illuminate\Support\ServiceProvider;

class ChurchMeetServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Workdo\ChurchMeet\Console\Commands\ZoomSyncCommand::class,
            ]);
        }
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'churchmeet');
        $this->loadMigrationsFrom(__DIR__ . '/../../Database/Migrations');

        $this->app->afterResolving(\Illuminate\Console\Scheduling\Schedule::class, function ($schedule) {
            $schedule->command('churchmeet:zoom-sync')->everyFiveMinutes();
        });
    }
}
