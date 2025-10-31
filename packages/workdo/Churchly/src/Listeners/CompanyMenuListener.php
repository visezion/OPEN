<?php
namespace Workdo\Churchly\Listeners;

use App\Events\CompanyMenuEvent;

class CompanyMenuListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanyMenuEvent $event): void
    {
        $module = 'Churchly';
        $menu = $event->menu;
        $menu->add([
            'category' => 'General',
            'title' => __('Church Dashboard'),
            'icon' => '',
            'name' => 'Churchly-dashboard',
            'parent' => 'dashboard',
            'order' => 20,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'dashboard.church',
            'module' => $module,
            'permission' => 'churchly dashboard manage'
        ]);
        
        
         $menu->add([
            'category' => 'General',
            'title' => __('Members Management'),
            'icon' => '',
            'name' => 'church-timmer',
            'parent' => 'user-management',
            'order' => 10,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'members.index',
            'module' => $module,
            'permission' => 'church_member manage'
        ]);
        
         $menu->add([
            'category' => 'Church',
            'title' => __('Feedback System'),
            'icon' => 'ti ti-clipboard-list',
            'name' => 'church-timmer',
            'parent' => '',
            'order' => 400,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'feedback.dashboard',
            'module' => $module,
            'permission' => 'churchly dashboard manage'
        ]);
       

        
                
        ///////// attendance Management/////
        $menu->add([
            'category' => 'Church',
            'title' => __('Event & Attendance'),
            'icon' => 'check',
            'name' => 'attendance',
            'parent' => null,
            'order' => 10,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'churchly dashboard manage'
        ]);

         $menu->add([
            'category' => 'Church',
            'title' => __('Events Management'),
            'icon' => '',
            'name' => 'events',
            'parent' => 'attendance',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchly.events.index',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);

         $menu->add([
            'category' => 'Church',
            'title' => __('Event Attendance'),
            'icon' => '',
            'name' => 'attendance-sessions',
            'parent' => 'attendance',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchly.attendance_events.index',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);

         $menu->add([
            'category' => 'Church',
            'title' => __('Event Stage Timer'),
            'icon' => '',
            'name' => 'church-timmer',
            'parent' => 'attendance',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'timer.church',
            'module' => $module,
            'permission' => 'church_program_timer manage'
        ]);
        


        $menu->add([
            'category' => 'Church',
            'title' => __('Reports & Analytics'),
            'icon' => '',
            'name' => 'reports-analytics',
            'parent' => 'attendance',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchly.attendance.reports.dashboard',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Leaderboard'),
            'icon' => '',
            'name' => 'leaderboard',
            'parent' => 'attendance',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchly.attendance.reports.dashboard',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);
////////////////////////////// Discipleship Management/////////////////////////

        $menu->add([
            'category' => 'Church',
            'title' => __('Discipleship'),
            'icon' => 'arrows-split-2',
            'name' => 'discipleship',
            'parent' => null,
            'order' => 10,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'churchly dashboard manage'
        ]);

         $menu->add([
            'category' => 'Church',
            'title' => __('Discipleship Dashboard'),
            'icon' => '',
            'name' => 'discipleship-dashboard',
            'parent' => 'discipleship',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'discipleship.dashboard',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);

        
         $menu->add([
            'category' => 'Church',
            'title' => __('Members Progress'),
            'icon' => '',
            'name' => 'members-pr',
            'parent' => 'discipleship',
            'order' => 2,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'discipleship.progress',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('My Progress '),
            'icon' => '',
            'name' => 'members-pr',
            'parent' => 'discipleship',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'discipleship.my_journey',
            'module' => $module,
            'permission' => ''
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Discipleship Approvers'),
            'icon' => '',
            'name' => 'members-pr',
            'parent' => 'discipleship',
            'order' => 2,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'discipleship.approvers.index',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Pathways Setup'),
            'icon' => '',
            'name' => 'discipleship-pathways ',
            'parent' => 'discipleship',
            'order' => 400,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'discipleship.index',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);

        ///Automation & Tasks///
        $menu->add([
            'category' => 'Church',
            'title' => __('Automation & Tasks'),
            'icon' => 'ti ti-vector-triangle',
            'name' => 'automation',
            'parent' => null,
            'order' => 10,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'churchly dashboard manage'
        ]);

         $menu->add([
            'category' => 'Church',
            'title' => __('Automated Reminders'),
            'icon' => '',
            'name' => 'automated-reminders',
            'parent' => 'automation',
            'order' => 1,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Church Settings'),
            'icon' => ' ti ti-tool',
            'name' => 'church_settings',
            'parent' => null,
            'order' => 400,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'churchly dashboard manage'
        ]);


         $menu->add([
            'category' => 'Church',
            'title' => __('App/Web Settings'),
            'icon' => ' ti ti-phone',
            'name' => 'appweb_builder',
            'parent' => null,
            'order' => 400,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => $module,
            'permission' => 'churchly dashboard manage'
        ]);

        $menu->add([
            'category' => 'Church',
            'title' => __('Mobile App Builder'),
            'icon' => '',
            'name' => 'app_builder',
            'parent' => 'appweb_builder',
            'order' => 400,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'app-builder.index',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);

        // YouTube Sync settings
        $menu->add([
            'category' => 'Church',
            'title' => __('YouTube Sync'),
            'icon' => 'brand-youtube',
            'name' => 'youtube-sync',
            'parent' => 'appweb_builder',
            'order' => 450,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchly.youtube.index',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);
        // API Docs link under App/Web Settings
        $menu->add([
            'category' => 'Church',
            'title' => __('API Docs'),
            'icon' => 'ti ti-book',
            'name' => 'churchly_api_docs',
            'parent' => 'appweb_builder',
            'order' => 410,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchly.api.docs',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);

         
        $menu->add([
            'category' => 'Church',
            'title' => __('Church Setup'),
            'icon' => '',
            'name' => 'system-setup',
            'parent' => 'church_settings',
            'order' => 400,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => 'churchbranch.index',
            'module' => $module,
            'permission' => 'church_settings manage'
        ]);
    }
}







