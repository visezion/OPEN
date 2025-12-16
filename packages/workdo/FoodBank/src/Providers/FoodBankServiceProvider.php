<?php

namespace Workdo\FoodBank\Providers;

use Illuminate\Support\ServiceProvider;
use Workdo\FoodBank\Listeners\FoodBankMenuListener;
use Illuminate\Support\Facades\Event;

class FoodBankServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/foodbank.php', 'foodbank');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'foodbank');

        Event::listen('App\Events\CompanyMenuEvent', FoodBankMenuListener::class);
    }
}
