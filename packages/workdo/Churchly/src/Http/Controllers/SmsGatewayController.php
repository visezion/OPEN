<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Workdo\Churchly\Entities\SmsGateway;
use Workdo\Churchly\Entities\SmsGatewaySetting;
use Workdo\Churchly\Entities\ZenderWaGroup;

class SmsGatewayController extends Controller
{
    /**
     * Display the gateway management page.
     */
    public function index()
    {
        // Placeholder: Uncomment this when needed
         $gateways = SmsGateway::where('workspace_id', getActiveWorkSpace())->get();
       
         return view('churchly::sms.index', compact('gateways'));
    }

    /**
     * Store a new SMS gateway for the current workspace.
     */
   public function store(Request $request)
{
    $request->validate([
        'name'      => 'required|string|max:191',
        'driver'    => 'required|string|max:100',
        'api_key'   => 'required|string',
        'url'       => 'required|url',
        'service'   => 'nullable|string|in:whatsapp,sms',
        'whatsapp'  => 'nullable|string',
        'device'    => 'nullable|string',
        'gateway'   => 'nullable|string',
        'sim'       => 'nullable|string|in:SIM 1,SIM 2',
    ]);

    $data = $request->only([
        'name',
        'driver',
        'api_key',
        'url',
        'service',
        'whatsapp',
        'device',
        'gateway',
        'sim',
    ]);

    $data['workspace_id'] = getActiveWorkSpace()->id;

    SmsGateway::create($data);

    return redirect()->back()->with('success', 'Gateway added successfully');
}


    /**
     * Delete an existing SMS gateway.
     */
    public function destroy(SmsGateway $gateway)
    {
        $gateway->delete();
        return redirect()->back()->with('success', 'Gateway deleted');
    }

    /**
     * Display the Zender settings page.
     */
    public function edit()
    {
        $setting = SmsGatewaySetting::where('workspace_id', getActiveWorkSpace())->first();
        return view('churchly::sms.edit', ['config' => $setting?->config ?? []]);
      
    }

    /**
     * Update or create Zender WhatsApp settings for the workspace.
     */
    public function update(Request $request)
{
    $request->validate([
        'url'      => 'required|url',
        'token'    => 'required|string',
        'service'  => 'required|string|in:whatsapp,sms',
        'whatsapp' => 'nullable|string',
        'device'   => 'nullable|string',
        'gateway'  => 'nullable|string',
        'sim'      => 'nullable|string|in:SIM 1,SIM 2',
    ]);

    SmsGatewaySetting::updateOrCreate(
        ['workspace_id' => getActiveWorkSpace()],
        [
            'driver' => 'zender',
            'config' => [
                'url'      => rtrim($request->url, '/'),
                'token'    => $request->token,
                'service'  => $request->service,
                'whatsapp' => $request->whatsapp,
                'device'   => $request->device,
                'gateway'  => $request->gateway,
                'sim'      => $request->sim,
            ],
            'is_active' => true,
        ]
    );

    return redirect()->back()->with('success', 'Zender settings saved!');
}



    /**
     * Send a WhatsApp message using workspace's Zender config (reusable method).
     */
    public function sendZenderMessage($recipient, $message, $channel = 'whatsapp')
    {
        $setting = SmsGatewaySetting::where('workspace_id', getActiveWorkSpace())->first();

        if (!$setting || !$setting->is_active) {
            return [
                'status'  => 'error',
                'message' => 'Zender settings not configured or inactive.'
            ];
        }

        $config = $setting->config;

        $message = $message ?: 'This is a message from Churchly via Zender API.';

        // Prepare payload depending on channel
        if ($channel === 'whatsapp') {
            if (empty($config['whatsapp'])) {
                return [
                    'status'  => 'error',
                    'message' => 'WhatsApp account ID is missing in configuration.'
                ];
            }

            $postData = [
                'secret'    => $config['token'],
                'account'   => $config['whatsapp'],
                'recipient' => ltrim($recipient, '+'),
                'type'      => 'text',
                'message'   => $message,
            ];
            $endpoint = '/api/send/whatsapp';

        } elseif ($channel === 'sms') {
            if (empty($config['device'])) {
                return [
                    'status'  => 'error',
                    'message' => 'SMS config invalid: Device ID is missing.'
                ];
            }

            $postData = [
                'secret'  => $config['token'],
                'mode'    => 'devices',
                'phone'   => $recipient, // keep + if present
                'message' => $message,
                'device'  => $config['device'],
                'sim'     => ($config['sim'] === 'SIM 2') ? 2 : 1,
            ];
            $endpoint = '/api/send/sms';

        } else {
            return [
                'status'  => 'error',
                'message' => "Unknown channel: $channel"
            ];
        }

        // Send via cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, rtrim($config['url'], '/') . $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            $errno = curl_errno($ch);
            curl_close($ch);
            return [
                'status'  => 'error',
                'message' => "cURL error ($errno): $error"
            ];
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code === 200) {
            return [
                'status'    => 'success',
                'http_code' => $http_code,
                'response'  => json_decode($response, true) ?? $response,
            ];
        }

        return [
            'status'    => 'error',
            'http_code' => $http_code,
            'response'  => $response,
        ];
    }




    
    /**
     * Send a test WhatsApp message using the current workspace's Zender settings.
     */
    
    public function testSend(Request $request)
    {
        $request->validate([
            'test_number' => 'required|string|min:10',
            'channel'     => 'required|in:whatsapp,sms',
        ]);

        $result = $this->sendZenderMessage($request->test_number, 'This is a test message from Churchly 🚀', $request->channel);

        if ($result['status'] === 'success') {
            return redirect()->back()->with('success', '✅ Test message sent! Response: ' . json_encode($result['response']));
        } else {
            return redirect()->back()->with('error', '❌ Failed: ' . ($result['message'] ?? json_encode($result['response'])));
        }
    }


    public function getWhatsAppGroups()
    {
        $setting = SmsGatewaySetting::where('workspace_id', getActiveWorkSpace())->first();

        if (!$setting || !$setting->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Zender configuration not found or inactive.',
            ], 400);
        }

        $config = $setting->config;

        // Construct the API endpoint with query parameters
        $url = rtrim($config['url'], '/') . '/api/get/wa.groups?' . http_build_query([
            'secret' => $config['token'],
            'unique' => $config['whatsapp'],
        ]);

        // Initialize cURL
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($http_code === 200) {
            return response()->json([
                'status' => 'success',
                'groups' => json_decode($response, true),
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'http_code' => $http_code,
                'message' => $response,
            ], $http_code);
        }
    }
}