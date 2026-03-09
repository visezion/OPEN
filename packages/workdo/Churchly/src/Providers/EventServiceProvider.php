<?php
namespace Workdo\Churchly\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\CompanySettingEvent;
use App\Events\CompanySettingMenuEvent;
use App\Events\CompanyMenuEvent;
use Workdo\Churchly\Listeners\CompanyMenuListener;
use Workdo\Churchly\Listeners\CompanySettingListener;
use Workdo\Churchly\Listeners\CompanySettingMenuListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CompanyMenuEvent::class => [
            CompanyMenuListener::class,
        ],
        CompanySettingEvent::class => [
            CompanySettingListener::class,
        ],
        CompanySettingMenuEvent::class => [
            CompanySettingMenuListener::class,
        ],
    ];
}
