<?php

namespace Workdo\Churchly\Services\Sms\Drivers;

use Illuminate\Support\Facades\Http;

class ZenderDriver
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function send($to, $message)
    {
        $url = $this->config['url'] ?? '';
        $api_key = $this->config['api_key'] ?? '';
        $from = $this->config['from'] ?? 'Zender';

        $response = Http::get($url, [
            'apikey'  => $api_key,
            'number'  => $to,
            'message' => $message,
            'sendername' => $from,
        ]);

        return $response->successful();
    }
}
