<?php

namespace Workdo\ChurchMeet\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Workdo\ChurchMeet\Entities\{ZoomSyncSetting, AttendanceEvent, ZoomParticipant};
use Workdo\ChurchMeet\Services\JitsiMeetingService;
use Workdo\ChurchMeet\Services\ZoomSyncService;

class ZoomIntegrationController extends Controller
{
    
public function index()
    {
        $setting = ZoomSyncSetting::firstOrNew(['workspace_id'=>getActiveWorkSpace()]);
        $setting->preferred_platform = $setting->preferred_platform ?: 'jitsi';
        $setting->jitsi_enabled = $setting->jitsi_enabled ?? true;
        $setting->jitsi_server_domain = $setting->jitsi_server_domain ?: JitsiMeetingService::DEFAULT_DOMAIN;
        $recentEvents = AttendanceEvent::where('workspace_id', getActiveWorkSpace())
            ->whereNotNull('meeting_id')->latest()->limit(5)->get();
        $recentParticipants = ZoomParticipant::where('workspace_id', getActiveWorkSpace())
            ->latest()->limit(20)->get();
        return view('churchmeet::integrations.index', compact('setting','recentEvents','recentParticipants'));
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'preferred_platform' => 'required|string|in:zoom,jitsi',
            'jitsi_enabled' => 'nullable|boolean',
            'jitsi_server_domain' => 'nullable|string|max:191',
            'jitsi_room_prefix' => 'nullable|string|max:100',
            'account_id' => 'nullable|string',
            'client_id' => 'nullable|string',
            'client_secret' => 'nullable|string',
            'host_user_id' => 'nullable|string',
            'meeting_sdk_key' => 'nullable|string',
            'meeting_sdk_secret' => 'nullable|string',
            'interval_minutes' => 'required|integer|min:5|max:1440',
            'active' => 'nullable|boolean',
        ]);
        $s = ZoomSyncSetting::firstOrNew(['workspace_id'=>getActiveWorkSpace()]);
        $s->fill($data);
        $s->workspace_id = getActiveWorkSpace();
        $s->active = (bool)($data['active'] ?? false);
        $s->jitsi_enabled = (bool)($data['jitsi_enabled'] ?? false);
        $jitsiServerDomain = trim((string) ($data['jitsi_server_domain'] ?? ''));
        $s->jitsi_server_domain = $jitsiServerDomain;
        $s->jitsi_room_prefix = trim((string) ($data['jitsi_room_prefix'] ?? '')) ?: null;
        $s->preferred_platform = !$s->jitsi_enabled && $data['preferred_platform'] === 'jitsi'
            ? 'zoom'
            : $data['preferred_platform'];

        if ($jitsiServerDomain === '') {
            $s->jitsi_server_domain = JitsiMeetingService::DEFAULT_DOMAIN;
        }
        $s->save();
        return back()->with('success','Integration settings saved.');
    }

    public function test(ZoomSyncService $service)
    {
        $s = ZoomSyncSetting::firstOrNew(['workspace_id'=>getActiveWorkSpace()]);
        $ok = (bool)$service->ensureAccessToken($s);
        return back()->with($ok?'success':'error', $ok?'Connection OK':'Unable to obtain access token');
    }

    public function syncNow(ZoomSyncService $service)
    {
        $s = ZoomSyncSetting::firstOrNew(['workspace_id'=>getActiveWorkSpace()]);
        $count = $service->syncDue($s);
        $s->last_synced_at = now();
        $s->save();
        return back()->with('success', "Synced {$count} participant rows.");
    }
}










