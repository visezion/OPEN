<?php

namespace Workdo\Churchly\Helpers\SMS;

use Workdo\Churchly\Entities\SmsGatewaySetting;

class SmsService
{
    public function __construct(public int $workspaceId) {}

    public function send(string $to, string $message): bool
    {
        $setting = SmsGatewaySetting::where('workspace_id', $this->workspaceId)
            ->where('is_active', true)->first();

        if (!$setting) {
            throw new \Exception('No active SMS gateway for this workspace');
        }

        return match ($setting->driver) {
            'zender' => (new ZenderSmsService($setting->config))->send($to, $message),
            default => throw new \Exception("Unsupported driver: {$setting->driver}"),
        };
    }
}
