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
            'icon' => 'video',
            'name' => 'churchmeet',
            'parent' => null,
            'order' => 5,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'churchly dashboard manage',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Event Management'),
            'icon' => '',
            'name' => 'churchmeet-events-group',
            'parent' => 'churchmeet',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'churchly event manage',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Events'),
            'icon' => '',
            'name' => 'churchmeet-events',
            'parent' => 'churchmeet-events-group',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchmeet.events.index',
            'module' => $module,
            'permission' => 'churchly event manage',
        ]);


        $menu->add([
            'category' => 'Church',
            'title' => __('Event Analytics'),
            'icon' => '',
            'name' => 'churchmeet-events-analytics',
            'parent' => 'churchmeet-events-group',
            'order' => 3,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchmeet.events.analytics.overall',
            'module' => $module,
            'permission' => 'attendance view',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Attendance'),
            'icon' => '',
            'name' => 'churchmeet-attendance-group',
            'parent' => 'churchmeet',
            'order' => 2,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'churchly attendance manage',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Attendance Sessions'),
            'icon' => '',
            'name' => 'churchmeet-attendance',
            'parent' => 'churchmeet-attendance-group',
            'order' => 1,
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
            'parent' => 'churchmeet-attendance-group',
            'order' => 3,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchmeet.attendance.reports.dashboard',
            'module' => $module,
            'permission' => 'attendance view',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Live & Tools'),
            'icon' => '',
            'name' => 'churchmeet-tools-group',
            'parent' => 'churchmeet',
            'order' => 3,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'churchly settings manage',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Zoom Integration'),
            'icon' => '',
            'name' => 'churchmeet-zoom',
            'parent' => 'churchmeet-tools-group',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchmeet.zoom.index',
            'module' => $module,
            'permission' => 'churchly settings manage',
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Event Stage Timer'),
            'icon' => '',
            'name' => 'churchmeet-timer',
            'parent' => 'churchmeet-tools-group',
            'order' => 2,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'timer.church',
            'module' => $module,
            'permission' => 'churchly dashboard manage',
        ]);
    }
}
