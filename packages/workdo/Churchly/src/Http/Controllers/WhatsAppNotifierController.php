<?php 

namespace Workdo\Churchly\Helpers;

use Illuminate\Support\Facades\Log;
use Workdo\Churchly\Http\Controllers\SmsGatewayController;

class WhatsAppNotifier
{
    public static function sendToGroup($groupId, $message)
    {
        try {
            $gateway = app(SmsGatewayController::class);

            $response = $gateway->sendWhatsAppGroupMessage($groupId, $message);

            Log::info('WhatsApp feedback notification sent', [
                'group_id' => $groupId,
                'message'  => $message,
                'response' => $response,
            ]);

            return $response;
        } catch (\Throwable $e) {
            Log::error('Failed to send WhatsApp feedback notification', [
                'group_id' => $groupId,
                'exception' => $e,
            ]);
            return false;
        }
    }
}
