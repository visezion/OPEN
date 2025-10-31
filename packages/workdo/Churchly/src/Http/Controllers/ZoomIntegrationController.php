<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Workdo\Churchly\Entities\{ZoomSyncSetting, AttendanceEvent, ZoomParticipant};
use Workdo\Churchly\Services\ZoomSyncService;

class ZoomIntegrationController extends Controller
{
    
public function index()
    {
        $setting = ZoomSyncSetting::firstOrNew(['workspace_id'=>getActiveWorkSpace()]);
        $recentEvents = AttendanceEvent::where('workspace_id', getActiveWorkSpace())
            ->whereNotNull('meeting_id')->latest()->limit(5)->get();
        $recentParticipants = ZoomParticipant::where('workspace_id', getActiveWorkSpace())
            ->latest()->limit(20)->get();
        return view('churchly::integrations.zoom', compact('setting','recentEvents','recentParticipants'));
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'account_id' => 'nullable|string',
            'client_id' => 'nullable|string',
            'client_secret' => 'nullable|string',
            'interval_minutes' => 'required|integer|min:5|max:1440',
            'active' => 'nullable|boolean',
        ]);
        $s = ZoomSyncSetting::firstOrNew(['workspace_id'=>getActiveWorkSpace()]);
        $s->fill($data);
        $s->workspace_id = getActiveWorkSpace();
        $s->active = (bool)($data['active'] ?? false);
        $s->save();
        return back()->with('success','Zoom settings saved.');
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









