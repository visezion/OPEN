<?php

namespace Workdo\ChurchMeet\Services;

use Firebase\JWT\JWT;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;
use RuntimeException;
use Workdo\ChurchMeet\Entities\AttendanceEvent;
use Workdo\ChurchMeet\Entities\ZoomSyncSetting;

class LivekitMeetingService
{
    public const DEFAULT_TOKEN_TTL_MINUTES = 120;

    public function canUseLiveKit(?ZoomSyncSetting $setting): bool
    {
        if (!$setting) {
            return false;
        }

        return (bool) $setting->livekit_enabled
            && filled($setting->livekit_server_url)
            && filled($setting->livekit_api_key)
            && filled($setting->livekit_api_secret);
    }

    public function createRoomForAttendanceEvent(
        ZoomSyncSetting $setting,
        AttendanceEvent $attendanceEvent,
        ?string $roomName = null
    ): AttendanceEvent {
        $this->assertConfigured($setting);

        $resolvedRoomName = $this->sanitizeRoomName($roomName ?: $attendanceEvent->meeting_id ?: $this->makeRoomName($attendanceEvent));
        $joinUrl = route('churchmeet.meetings.join', $attendanceEvent->id);

        $enabledMethods = collect($attendanceEvent->enabled_methods ?? [])
            ->push('livekit')
            ->unique()
            ->values()
            ->all();

        $attendanceEvent->forceFill([
            'mode' => $attendanceEvent->mode === 'onsite' ? 'online' : $attendanceEvent->mode,
            'online_platform' => 'livekit',
            'meeting_id' => $resolvedRoomName,
            'meeting_link' => $joinUrl,
            'host_start_url' => $joinUrl,
            'meeting_passcode' => null,
            'auto_log_attendance' => true,
            'enabled_methods' => $enabledMethods,
        ])->save();

        return $attendanceEvent->refresh();
    }

    public function makeParticipantToken(
        ZoomSyncSetting $setting,
        string $roomName,
        string $identity,
        ?string $displayName = null,
        bool $roomAdmin = false
    ): string {
        $this->assertConfigured($setting);

        $now = time();
        $ttlMinutes = max(5, (int) ($setting->livekit_token_ttl_minutes ?: static::DEFAULT_TOKEN_TTL_MINUTES));

        $payload = [
            'iss' => $setting->livekit_api_key,
            'sub' => $identity,
            'nbf' => $now,
            'exp' => $now + ($ttlMinutes * 60),
            'video' => [
                'room' => $roomName,
                'roomJoin' => true,
                'canPublish' => true,
                'canSubscribe' => true,
                'canPublishData' => true,
                'roomAdmin' => $roomAdmin,
            ],
        ];

        if ($displayName) {
            $payload['name'] = $displayName;
        }

        return JWT::encode($payload, $setting->livekit_api_secret, 'HS256');
    }

    public function websocketUrl(?string $serverUrl): ?string
    {
        $normalized = $this->normalizeServerUrl($serverUrl);

        if (!$normalized) {
            return null;
        }

        $parts = parse_url($normalized);

        if (!$parts || empty($parts['host'])) {
            return null;
        }

        $scheme = ($parts['scheme'] ?? 'https') === 'http' ? 'ws' : 'wss';
        $host = $parts['host'];
        $port = isset($parts['port']) ? ':' . $parts['port'] : '';
        $path = isset($parts['path']) ? rtrim($parts['path'], '/') : '';

        return $scheme . '://' . $host . $port . $path;
    }

    public function normalizeServerUrl(?string $serverUrl): ?string
    {
        $value = trim((string) $serverUrl);

        if ($value === '') {
            return null;
        }

        if (!Str::contains($value, '://')) {
            $value = 'https://' . $value;
        }

        $parts = parse_url($value);

        if (!$parts || empty($parts['host'])) {
            return null;
        }

        $scheme = strtolower((string) ($parts['scheme'] ?? 'https'));

        if ($scheme === 'ws') {
            $scheme = 'http';
        } elseif ($scheme === 'wss') {
            $scheme = 'https';
        }

        $host = strtolower((string) $parts['host']);
        $port = isset($parts['port']) ? ':' . $parts['port'] : '';
        $path = isset($parts['path']) ? rtrim((string) $parts['path'], '/') : '';

        return $scheme . '://' . $host . $port . $path;
    }

    public function makeIdentityForUser(?Authenticatable $user): string
    {
        if ($user && $user->getAuthIdentifier()) {
            return 'open-user-' . $user->getAuthIdentifier();
        }

        return 'guest-' . Str::lower(Str::random(12));
    }

    public function makeDisplayNameForUser(?Authenticatable $user): string
    {
        $name = trim((string) ($user?->name ?? 'Church Member'));

        return $name !== '' ? $name : 'Church Member';
    }

    public function sanitizeRoomName(?string $roomName): string
    {
        $room = preg_replace('/[^A-Za-z0-9_-]+/', '-', trim((string) $roomName));
        $room = trim((string) $room, '-_');

        return $room !== '' ? Str::limit($room, 90, '') : 'churchmeet-livekit-room';
    }

    protected function makeRoomName(AttendanceEvent $attendanceEvent): string
    {
        $prefix = trim((string) optional(
            ZoomSyncSetting::where('workspace_id', $attendanceEvent->workspace_id)->first()
        )->livekit_room_prefix);
        $prefix = $prefix !== '' ? $this->sanitizeRoomName($prefix) : null;
        $title = optional($attendanceEvent->event)->title ?: 'churchmeet-livekit-room';
        $slug = Str::slug(Str::limit($title, 40, ''), '-');

        if ($slug === '') {
            $slug = 'churchmeet-livekit-room';
        }

        return implode('-', array_filter([
            $prefix,
            $slug,
            'ws' . $attendanceEvent->workspace_id,
            'ev' . $attendanceEvent->event_id,
        ]));
    }

    protected function assertConfigured(ZoomSyncSetting $setting): void
    {
        if (!$this->canUseLiveKit($setting)) {
            throw new RuntimeException('Configure LiveKit server URL, API key, and API secret before creating rooms.');
        }
    }
}
