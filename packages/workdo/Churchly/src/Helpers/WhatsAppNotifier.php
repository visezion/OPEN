<?php

namespace Workdo\Churchly\Helpers;

use Illuminate\Support\Facades\Log;
use Workdo\Churchly\Entities\SmsGatewaySetting;

class WhatsAppNotifier
{
    /**
     * Send a WhatsApp message to a group using workspace Zender settings
     */
    public static function sendToGroup(string $groupId, string $message): array
    {
        try {
            $setting = SmsGatewaySetting::where('workspace_id', getActiveWorkSpace())->first();

            if (!$setting || !$setting->is_active) {
                Log::error("❌ WhatsAppNotifier: No active Zender config for workspace " . getActiveWorkSpace());
                return [
                    'status' => 'error',
                    'message' => 'Zender config not found for workspace'
                ];
            }

            $config = $setting->config;

            $postData = [
                'secret'    => $config['token'],
                'account'   => $config['whatsapp'],
                'recipient' => $groupId,
                'type'      => 'text',
                'message'   => $message,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $config['url'] . '/api/send/whatsapp');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code === 200) {
                Log::info("✅ WhatsAppNotifier: Message sent to group {$groupId}", [
                    'workspace' => getActiveWorkSpace(),
                    'response'  => $response,
                ]);
                return [
                    'status' => 'success',
                    'http_code' => $http_code,
                    'response' => json_decode($response, true),
                ];
            } else {
                Log::error("❌ WhatsAppNotifier: Failed sending to group {$groupId}", [
                    'workspace' => getActiveWorkSpace(),
                    'http_code' => $http_code,
                    'response'  => $response,
                ]);
                return [
                    'status' => 'error',
                    'http_code' => $http_code,
                    'response' => $response,
                ];
            }
        } catch (\Throwable $e) {
            Log::error("💥 WhatsAppNotifier exception: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
