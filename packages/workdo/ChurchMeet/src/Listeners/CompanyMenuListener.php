<?php

namespace Workdo\ChurchMeet\Listeners;

use App\Events\CompanyMenuEvent;

class CompanyMenuListener
{
    public function handle(CompanyMenuEvent $event): void
    {
        $module = 'ChurchMeet';
        $menu = $event->menu;

        $menu->add([
            'category' => 'Church',
            'title' => __('ChurchMeet'),
            'icon' => 'building-church',
            'name' => 'churchmeet',
            'parent' => null,
            'order' => 5,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchmeet.events.analytics.overall',
            'module' => $module,
            'permission' => 'churchly dashboard manage',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Overview'),
            'icon' => '',
            'name' => 'churchmeet-overview',
            'parent' => 'churchmeet',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchmeet.events.analytics.overall',
            'module' => $module,
            'permission' => 'attendance view',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('All Events'),
            'icon' => '',
            'name' => 'churchmeet-events',
            'parent' => 'churchmeet',
            'order' => 2,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchmeet.events.index',
            'module' => $module,
            'permission' => 'churchly event manage',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Attendance Sessions'),
            'icon' => '',
            'name' => 'churchmeet-attendance',
            'parent' => 'churchmeet',
            'order' => 3,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchmeet.attendance_events.index',
            'module' => $module,
            'permission' => 'churchly attendance manage',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Attendance Reports'),
            'icon' => '',
            'name' => 'churchmeet-reports',
            'parent' => 'churchmeet',
            'order' => 4,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchmeet.attendance.reports.dashboard',
            'module' => $module,
            'permission' => 'attendance view',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Meeting Integrations'),
            'icon' => '',
            'name' => 'churchmeet-integrations',
            'parent' => 'churchmeet',
            'order' => 5,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchmeet.integrations.index',
            'module' => $module,
            'permission' => 'churchly settings manage',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Event Stage Timer'),
            'icon' => '',
            'name' => 'churchmeet-timer',
            'parent' => 'churchmeet',
            'order' => 6,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'timer.church',
            'module' => $module,
            'permission' => 'churchly dashboard manage',
        ]);
    }
}
