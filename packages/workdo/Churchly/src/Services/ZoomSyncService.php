<?php

namespace Workdo\Churchly\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Workdo\Churchly\Entities\{ZoomSyncSetting, ZoomParticipant, AttendanceEvent, ChurchMember, AttendanceRecord};

class ZoomSyncService
{
    public function ensureAccessToken(ZoomSyncSetting $setting): ?string
    {
        if ($setting->oauth_access_token && $setting->token_expires_at && $setting->token_expires_at->gt(now()->addMinute())) {
            return $setting->oauth_access_token;
        }
        if (!$setting->account_id || !$setting->client_id || !$setting->client_secret) {
            return null;
        }
        try {
            $resp = Http::withBasicAuth($setting->client_id, $setting->client_secret)
                ->asForm()
                ->post('https://zoom.us/oauth/token', [
                    'grant_type' => 'account_credentials',
                    'account_id' => $setting->account_id,
                ]);
            $resp->throw();
            $data = $resp->json();
            $setting->oauth_access_token = $data['access_token'] ?? null;
            $setting->token_expires_at = now()->addSeconds((int)($data['expires_in'] ?? 3500));
            $setting->save();
            return $setting->oauth_access_token;
        } catch (\Throwable $e) {
            Log::error('[ZoomSync] token error: '.$e->getMessage(), ['workspace'=>$setting->workspace_id]);
            return null;
        }
    }

    public function syncDue(ZoomSyncSetting $setting): int
    {
        $count = 0;
        $events = AttendanceEvent::where('workspace_id', $setting->workspace_id)
            ->whereNotNull('meeting_id')
            ->where('created_at', '>=', now()->subDays(2))
            ->limit(20)->get();
        foreach ($events as $ev) {
            $count += $this->syncAttendanceEvent($setting, $ev);
        }
        return $count;
    }

    public function syncAttendanceEvent(ZoomSyncSetting $setting, AttendanceEvent $attendanceEvent): int
    {
        $token = $this->ensureAccessToken($setting);
        if (!$token) return 0;
        $meetingId = $attendanceEvent->meeting_id;
        if (!$meetingId) return 0;
        try {
            // Get meeting details to obtain UUID
            $m = Http::withToken($token)->get("https://api.zoom.us/v2/meetings/{$meetingId}");
            $uuid = $m->ok() ? ($m->json()['uuid'] ?? null) : null;
            if (!$uuid) {
                // fallback: try using the id directly (some accounts allow it)
                $uuid = $meetingId;
            }
            $encodedUuid = rawurlencode($uuid);
            $inserted = 0;
            $next = null;
            do {
                $params = ['page_size'=>100];
                if ($next) $params['next_page_token'] = $next;
                $resp = Http::withToken($token)->get("https://api.zoom.us/v2/past_meetings/{$encodedUuid}/participants", $params);
                if (!$resp->ok()) break;
                $body = $resp->json();
                foreach (($body['participants'] ?? []) as $p) {
                    $memberId = null;
                    if (!empty($p['email'])) {
                        $member = ChurchMember::forWorkspace()->where('email', $p['email'])->first();
                        $memberId = $member?->id;
                    }
                    ZoomParticipant::create([
                        'workspace_id' => $setting->workspace_id,
                        'meeting_id' => (string)$meetingId,
                        'meeting_uuid' => $uuid,
                        'attendance_event_id' => $attendanceEvent->id,
                        'member_id' => $memberId,
                        'user_email' => $p['email'] ?? null,
                        'user_name' => $p['name'] ?? null,
                        'zoom_user_id' => $p['id'] ?? null,
                        'join_time' => isset($p['join_time']) ? \Carbon\Carbon::parse($p['join_time']) : null,
                        'leave_time' => isset($p['leave_time']) ? \Carbon\Carbon::parse($p['leave_time']) : null,
                        'duration' => $p['duration'] ?? null,
                        'raw_json' => json_encode($p),
                    ]);
                    if ($memberId) {
                        AttendanceRecord::updateOrCreate([
                            'attendance_event_id' => $attendanceEvent->id,
                            'member_id' => $memberId,
                        ], [
                            'workspace_id' => $attendanceEvent->workspace_id,
                            'status' => 'present',
                            'check_in_time' => isset($p['join_time']) ? \Carbon\Carbon::parse($p['join_time']) : now(),
                            'device_used' => 'online',
                        ]);
                    }
                    $inserted++;
                }
                $next = $body['next_page_token'] ?? null;
            } while ($next);
            return $inserted;
        } catch (\Throwable $e) {
            Log::error('[ZoomSync] sync error: '.$e->getMessage(), ['workspace'=>$setting->workspace_id, 'meeting'=>$meetingId]);
            return 0;
        }
    }
}

