<?php
namespace Workdo\Churchly\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\CompanyMenuEvent;
use Workdo\Churchly\Listeners\CompanyMenuListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CompanyMenuEvent::class => [
            CompanyMenuListener::class,
        ],
    ];
}
