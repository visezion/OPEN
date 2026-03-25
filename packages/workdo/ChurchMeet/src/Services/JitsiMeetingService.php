<?php

namespace Workdo\ChurchMeet\Services;

use Illuminate\Support\Str;
use Workdo\ChurchMeet\Entities\AttendanceEvent;
use Workdo\ChurchMeet\Entities\ZoomSyncSetting;

class JitsiMeetingService
{
    public const DEFAULT_DOMAIN = 'meet.jit.si';

    public function createRoomForAttendanceEvent(
        AttendanceEvent $attendanceEvent,
        ?string $domain = null,
        ?string $roomName = null
    ): AttendanceEvent {
        $details = $this->getMeetingDetails(
            $attendanceEvent,
            $domain,
            $roomName
        );

        $enabledMethods = collect($attendanceEvent->enabled_methods ?? [])
            ->push('jitsi')
            ->unique()
            ->values()
            ->all();

        $attendanceEvent->forceFill([
            'mode' => $attendanceEvent->mode === 'onsite' ? 'online' : $attendanceEvent->mode,
            'online_platform' => 'jitsi',
            'meeting_id' => $details['room_name'],
            'meeting_link' => $details['meeting_link'],
            'host_start_url' => $details['meeting_link'],
            'meeting_passcode' => null,
            'auto_log_attendance' => true,
            'enabled_methods' => $enabledMethods,
        ])->save();

        return $attendanceEvent->refresh();
    }

    public function getMeetingDetails(
        AttendanceEvent $attendanceEvent,
        ?string $domain = null,
        ?string $roomName = null
    ): array {
        $resolvedDomain = $this->normalizeDomain($domain ?: $attendanceEvent->meeting_link ?: $this->defaultDomainForWorkspace($attendanceEvent->workspace_id));
        $resolvedRoom = $this->sanitizeRoomName($roomName ?: $attendanceEvent->meeting_id ?: $this->makeRoomName($attendanceEvent));

        return [
            'domain' => $resolvedDomain,
            'room_name' => $resolvedRoom,
            'meeting_link' => 'https://' . $resolvedDomain . '/' . $resolvedRoom,
        ];
    }

    public function normalizeDomain(?string $domainOrUrl): string
    {
        $value = trim((string) $domainOrUrl);

        if ($value === '') {
            return self::DEFAULT_DOMAIN;
        }

        if (Str::contains($value, '://')) {
            $host = parse_url($value, PHP_URL_HOST);

            if (is_string($host) && $host !== '') {
                return strtolower($host);
            }
        }

        $value = preg_replace('#^https?://#i', '', $value);
        $value = strtok($value, '/');
        $value = trim((string) $value);

        return $value !== '' ? strtolower($value) : self::DEFAULT_DOMAIN;
    }

    public function sanitizeRoomName(?string $roomName): string
    {
        $room = preg_replace('/[^A-Za-z0-9_-]+/', '-', trim((string) $roomName));
        $room = trim((string) $room, '-_');

        return $room !== '' ? Str::limit($room, 90, '') : 'churchmeet-room';
    }

    protected function makeRoomName(AttendanceEvent $attendanceEvent): string
    {
        $prefix = trim((string) optional(
            ZoomSyncSetting::where('workspace_id', $attendanceEvent->workspace_id)->first()
        )->jitsi_room_prefix);
        $prefix = $prefix !== '' ? $this->sanitizeRoomName($prefix) : null;
        $title = optional($attendanceEvent->event)->title ?: 'churchmeet-room';
        $slug = Str::slug(Str::limit($title, 40, ''), '-');

        if ($slug === '') {
            $slug = 'churchmeet-room';
        }

        return implode('-', array_filter([
            $prefix,
            $slug,
            'ws' . $attendanceEvent->workspace_id,
            'ev' . $attendanceEvent->event_id,
        ]));
    }

    protected function defaultDomainForWorkspace(?int $workspaceId): string
    {
        if (!$workspaceId) {
            return self::DEFAULT_DOMAIN;
        }

        $domain = optional(
            ZoomSyncSetting::where('workspace_id', $workspaceId)->first()
        )->jitsi_server_domain;

        return $this->normalizeDomain($domain);
    }
}
