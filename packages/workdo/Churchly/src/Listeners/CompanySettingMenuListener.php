<?php

namespace Workdo\Churchly\Listeners;

use App\Events\CompanySettingMenuEvent;

class CompanySettingMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanySettingMenuEvent $event): void
    {
        $module = 'Churchly';
        $menu = $event->menu;
        $menu->add([
            'title' => __('Church Settings'),
            'name' => 'church-setting',
            'order' => 130,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'navigation' => 'church-sidenav',
            'module' => $module,
            'permission' => 'settings manage'
        ]);
    }
}
