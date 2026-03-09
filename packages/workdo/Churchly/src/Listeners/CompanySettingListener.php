<?php

namespace Workdo\Churchly\Listeners;

use App\Events\CompanySettingEvent;

class CompanySettingListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanySettingEvent $event): void
    {
        $module = 'Churchly';

        if (! in_array($module, $event->html->modules)) {
            return;
        }

        $html = $event->html;
        $settings = $html->getSettings();
        $output = view('churchly::settings.company_setup', compact('settings'));

        $html->add([
            'html' => $output->toHtml(),
            'order' => 130,
            'module' => $module,
            'permission' => 'church_settings manage',
        ]);
    }
}
