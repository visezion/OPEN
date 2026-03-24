<?php

namespace Workdo\Churchly\Services;

use Firebase\JWT\JWT;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Workdo\Churchly\Entities\AttendanceEvent;
use Workdo\Churchly\Entities\ZoomSyncSetting;

class ZoomMeetingService
{
    public function __construct(
        protected ZoomSyncService $zoomSyncService
    ) {
    }

    public function createMeetingForAttendanceEvent(ZoomSyncSetting $setting, AttendanceEvent $attendanceEvent, string $hostUserId = 'me'): AttendanceEvent
    {
        $token = $this->zoomSyncService->ensureAccessToken($setting);

        if (!$token) {
            throw new RuntimeException('Zoom access token is not available.');
        }

        $event = $attendanceEvent->event;

        if (!$event) {
            throw new RuntimeException('Attendance event is not linked to a Churchly event.');
        }

        $startTime = $event->start_time ? Carbon::parse($event->start_time) : now()->addHour();
        $durationMinutes = max(15, $this->resolveDurationMinutes($event->start_time, $event->end_time));
        $password = $attendanceEvent->meeting_passcode ?: $this->generatePasscode();

        $payload = [
            'topic' => $event->title,
            'type' => 2,
            'agenda' => $event->description,
            'start_time' => $startTime->toIso8601String(),
            'duration' => $durationMinutes,
            'timezone' => config('app.timezone', 'UTC'),
            'password' => $password,
            'settings' => [
                'join_before_host' => false,
                'waiting_room' => true,
                'mute_upon_entry' => true,
                'participant_video' => false,
                'host_video' => true,
                'auto_recording' => 'none',
            ],
        ];

        $response = Http::withToken($token)
            ->acceptJson()
            ->post("https://api.zoom.us/v2/users/{$hostUserId}/meetings", $payload);

        if (!$response->successful()) {
            $message = Arr::get($response->json(), 'message', 'Unable to create Zoom meeting.');
            throw new RuntimeException($message);
        }

        $meeting = $response->json();

        $attendanceEvent->forceFill([
            'online_platform' => 'zoom',
            'meeting_id' => (string) ($meeting['id'] ?? ''),
            'meeting_passcode' => $meeting['password'] ?? $password,
            'meeting_link' => $meeting['join_url'] ?? null,
            'zoom_join_url' => $meeting['join_url'] ?? null,
            'host_start_url' => $meeting['start_url'] ?? null,
            'zoom_meeting_uuid' => $meeting['uuid'] ?? null,
            'zoom_created_at' => now(),
            'zoom_created_by' => auth()->id(),
        ])->save();

        return $attendanceEvent->fresh(['event']);
    }

    public function makeMeetingSdkSignature(ZoomSyncSetting $setting, string $meetingNumber, int $role = 0): string
    {
        if (!$setting->meeting_sdk_key || !$setting->meeting_sdk_secret) {
            throw new RuntimeException('Zoom Meeting SDK credentials are missing.');
        }

        $issuedAt = time() - 30;
        $expiresAt = $issuedAt + (2 * 60 * 60);

        return JWT::encode([
            'appKey' => $setting->meeting_sdk_key,
            'sdkKey' => $setting->meeting_sdk_key,
            'mn' => $meetingNumber,
            'role' => $role,
            'iat' => $issuedAt,
            'exp' => $expiresAt,
            'tokenExp' => $expiresAt,
        ], $setting->meeting_sdk_secret, 'HS256');
    }

    public function canUseMeetingSdk(?ZoomSyncSetting $setting): bool
    {
        return !empty($setting?->meeting_sdk_key) && !empty($setting?->meeting_sdk_secret);
    }

    protected function resolveDurationMinutes($startTime, $endTime): int
    {
        if (!$startTime || !$endTime) {
            return 60;
        }

        $minutes = Carbon::parse($startTime)->diffInMinutes(Carbon::parse($endTime), false);

        return $minutes > 0 ? $minutes : 60;
    }

    protected function generatePasscode(): string
    {
        return substr(strtoupper(bin2hex(random_bytes(4))), 0, 8);
    }
}
