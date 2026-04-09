<?php

namespace Workdo\ChurchMeet\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Workdo\ChurchMeet\Entities\AttendanceEvent;
use Workdo\ChurchMeet\Entities\AttendanceRecord;
use Workdo\ChurchMeet\Entities\ChurchMember;
use Workdo\ChurchMeet\Entities\ChurchDesignation;
use Workdo\ChurchMeet\Entities\Event;
use Workdo\ChurchMeet\Entities\ZoomSyncSetting;
use Workdo\ChurchMeet\Services\JitsiMeetingService;
use Workdo\ChurchMeet\Services\ZoomMeetingService;

class MeetingRoomController extends Controller
{
    public function createJitsiForEvent(int $eventId, JitsiMeetingService $jitsiMeetingService)
    {
        $event = Event::with('attendanceEvents.event')->inWorkspace()->findOrFail($eventId);
        $attendanceEvent = $this->resolveAttendanceEvent($event);

        abort_unless($this->userCanManageOnlineMeeting($attendanceEvent), 403, __('You are not allowed to create online meetings for this event.'));

        $jitsiMeetingService->createRoomForAttendanceEvent($attendanceEvent);

        return back()->with('success', __('Jitsi meeting room created successfully.'));
    }

    public function join(int $attendanceEventId, ZoomMeetingService $zoomMeetingService, JitsiMeetingService $jitsiMeetingService)
    {
        $attendanceEvent = AttendanceEvent::with('event')
            ->where('workspace_id', getActiveWorkSpace())
            ->findOrFail($attendanceEventId);

        abort_unless(Auth::check(), 403);

        $platform = strtolower((string) $attendanceEvent->online_platform);

        if ($platform === 'zoom') {
            abort_if(
                !$attendanceEvent->meeting_id && !$attendanceEvent->meeting_link && !$attendanceEvent->zoom_join_url,
                404,
                __('Zoom meeting not found for this event.')
            );

            $setting = ZoomSyncSetting::firstOrNew(['workspace_id' => getActiveWorkSpace()]);

            return view('churchmeet::integrations.zoom_join', [
                'attendanceEvent' => $attendanceEvent,
                'zoomSetting' => $setting,
                'meetingSdkEnabled' => $zoomMeetingService->canUseMeetingSdk($setting),
                'canStartMeeting' => $this->userCanManageOnlineMeeting($attendanceEvent) && !empty($attendanceEvent->host_start_url),
            ]);
        }

        if ($platform === 'jitsi') {
            abort_if(!$attendanceEvent->meeting_id && !$attendanceEvent->meeting_link, 404, __('Jitsi meeting room not found for this event.'));

            $meeting = $jitsiMeetingService->getMeetingDetails($attendanceEvent);

            return view('churchmeet::integrations.jitsi_join', [
                'attendanceEvent' => $attendanceEvent,
                'jitsiDomain' => $meeting['domain'],
                'jitsiRoomName' => $meeting['room_name'],
                'jitsiMeetingLink' => $meeting['meeting_link'],
                'canStartMeeting' => $this->userCanManageOnlineMeeting($attendanceEvent),
            ]);
        }

        abort(404, __('This event does not have a supported online meeting room.'));
    }

    public function markPresence(Request $request, int $attendanceEventId): JsonResponse
    {
        $attendanceEvent = AttendanceEvent::where('workspace_id', getActiveWorkSpace())->findOrFail($attendanceEventId);

        abort_unless(Auth::check(), 403);

        $user = Auth::user();
        $memberId = ChurchMember::forWorkspace()
            ->where('user_id', $user->id)
            ->value('id') ?? $user->id;

        $action = strtolower((string) $request->input('action', 'join'));
        if (!in_array($action, ['join', 'leave'], true)) {
            $action = 'join';
        }

        $record = AttendanceRecord::firstOrNew([
            'attendance_event_id' => $attendanceEvent->id,
            'member_id' => $memberId,
        ]);

        $record->workspace_id = getActiveWorkSpace();
        $record->status = 'present';
        $record->device_used = $attendanceEvent->online_platform ?: 'online';

        $now = Carbon::now();

        if (!$record->check_in_time) {
            $record->check_in_time = $now;
        }

        if ($action === 'join') {
            // Re-open active session if user reconnects.
            $record->check_out_time = null;
        } else {
            $record->check_out_time = $now;
        }

        $record->save();

        $stats = $this->buildPresenceStats($attendanceEvent, $record);

        return response()->json([
            'ok' => true,
            'action' => $action,
            'stats' => $stats,
            'check_in_time' => $record->check_in_time ? Carbon::parse($record->check_in_time)->toDateTimeString() : null,
            'check_out_time' => $record->check_out_time ? Carbon::parse($record->check_out_time)->toDateTimeString() : null,
        ]);
    }

    protected function buildPresenceStats(AttendanceEvent $attendanceEvent, AttendanceRecord $record): array
    {
        $checkIn = $record->check_in_time ? Carbon::parse($record->check_in_time) : null;
        $checkOut = $record->check_out_time ? Carbon::parse($record->check_out_time) : null;
        $effectiveEnd = $checkOut ?: Carbon::now();

        $joinedSeconds = $checkIn ? max(0, $checkIn->diffInSeconds($effectiveEnd)) : 0;

        $meetingSeconds = null;
        $event = $attendanceEvent->event;
        if (!empty($event?->start_time) && !empty($event?->end_time)) {
            $start = Carbon::parse($event->start_time);
            $end = Carbon::parse($event->end_time);
            $meetingSeconds = max(0, $start->diffInSeconds($end, false));
            if ($meetingSeconds === 0) {
                $meetingSeconds = null;
            }
        }

        $attendancePercent = null;
        if (!empty($meetingSeconds)) {
            $attendancePercent = round(min(100, ($joinedSeconds / $meetingSeconds) * 100), 2);
        }

        return [
            'joined_seconds' => $joinedSeconds,
            'joined_minutes' => (int) floor($joinedSeconds / 60),
            'meeting_seconds' => $meetingSeconds,
            'meeting_minutes' => $meetingSeconds ? (int) floor($meetingSeconds / 60) : null,
            'attendance_percent' => $attendancePercent,
        ];
    }

    protected function resolveAttendanceEvent(Event $event): AttendanceEvent
    {
        $attendanceEvent = $event->attendanceEvents()->first();

        if ($attendanceEvent) {
            return $attendanceEvent;
        }

        return AttendanceEvent::create([
            'workspace_id' => getActiveWorkSpace(),
            'branch_id' => null,
            'department_id' => null,
            'event_id' => $event->id,
            'mode' => 'online',
            'enabled_methods' => ['jitsi'],
            'online_platform' => 'jitsi',
            'auto_log_attendance' => true,
            'created_by' => Auth::id(),
        ]);
    }

    protected function userCanManageOnlineMeeting(?AttendanceEvent $attendanceEvent = null): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        if (
            $user->isAbleTo('churchly settings manage') ||
            $user->isAbleTo('churchly event manage') ||
            $user->isAbleTo('churchly event create')
        ) {
            return true;
        }

        $departmentId = $attendanceEvent?->department_id;

        if (!$departmentId) {
            return false;
        }

        $churchMember = ChurchMember::forWorkspace()->where('user_id', $user->id)->first();

        if (!$churchMember) {
            return false;
        }

        $leaderKeywords = ['leader', 'head', 'pastor', 'minister', 'director', 'coordinator', 'hod'];

        $designationIds = DB::table('church_member_department as member_department')
            ->where('member_department.church_member_id', $churchMember->id)
            ->where('member_department.department_id', $departmentId)
            ->pluck('member_department.designation_id')
            ->filter();

        if ($designationIds->isEmpty()) {
            return false;
        }

        return ChurchDesignation::whereIn('id', $designationIds)
            ->where(function ($query) use ($leaderKeywords) {
                foreach ($leaderKeywords as $keyword) {
                    $query->orWhere('name', 'like', '%' . $keyword . '%');
                }
            })
            ->exists();
    }
}
