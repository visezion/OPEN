<?php 

namespace Workdo\Churchly\Helpers\SMS;

class ZenderSmsService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct(array $config)
    {
        $this->apiUrl = $config['api_url'];
        $this->apiKey = $config['api_key'];
    }

    public function send(string $to, string $message): bool
    {
        $response = \Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiUrl . '/messages/send-text', [
            'recipient' => $to,
            'message' => $message,
        ]);

        return $response->successful();
    }
}
