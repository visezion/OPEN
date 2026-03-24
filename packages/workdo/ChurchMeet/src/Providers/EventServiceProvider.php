<?php

namespace Workdo\ChurchMeet\Providers;

use App\Events\CompanyMenuEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Workdo\ChurchMeet\Listeners\CompanyMenuListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CompanyMenuEvent::class => [
            CompanyMenuListener::class,
        ],
    ];
}
