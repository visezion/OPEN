<?php


namespace Workdo\Churchly\Services\Sms;

use Workdo\Churchly\Entities\SmsGatewaySetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $workspace_id;

    public function __construct($workspace_id)
    {
        $this->workspace_id = $workspace_id;
    }

    public function send($to, $message)
    {
        $setting = SmsGatewaySetting::where('workspace_id', $this->workspace_id)
            ->where('is_active', true)
            ->first();

        if (!$setting) {
            Log::warning("No active SMS gateway for workspace {$this->workspace_id}");
            return false;
        }

        $driver = $setting->driver;
        $config = $setting->config;

        return match ($driver) {
            'zender' => (new ZenderDriver($config))->send($to, $message),
            'twilio' => (new TwilioDriver($config))->send($to, $message),
            default => false,
        };
    }
}
