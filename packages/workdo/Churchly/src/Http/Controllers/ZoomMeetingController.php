<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Workdo\Churchly\Entities\AttendanceEvent;
use Workdo\Churchly\Entities\ChurchMember;
use Workdo\Churchly\Entities\Event;
use Workdo\Churchly\Entities\ZoomSyncSetting;
use Workdo\Churchly\Services\ZoomMeetingService;

class ZoomMeetingController extends Controller
{
    public function createForEvent(int $eventId, ZoomMeetingService $zoomMeetingService)
    {
        $event = Event::with('attendanceEvents')->inWorkspace()->findOrFail($eventId);
        $attendanceEvent = $this->resolveAttendanceEvent($event);

        $this->authorizeMeetingCreation($attendanceEvent);

        $setting = ZoomSyncSetting::firstOrNew(['workspace_id' => getActiveWorkSpace()]);

        if (!$setting->account_id || !$setting->client_id || !$setting->client_secret) {
            return back()->with('error', __('Configure Zoom Server-to-Server OAuth before creating meetings.'));
        }

        try {
            $zoomMeetingService->createMeetingForAttendanceEvent(
                $setting,
                $attendanceEvent,
                $setting->host_user_id ?: 'me'
            );
        } catch (\Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('success', __('Zoom meeting created successfully.'));
    }

    public function join(int $attendanceEventId, ZoomMeetingService $zoomMeetingService)
    {
        $attendanceEvent = AttendanceEvent::with('event')->where('workspace_id', getActiveWorkSpace())->findOrFail($attendanceEventId);

        $this->authorizeMeetingJoin($attendanceEvent);
        $meetingNumber = $this->normalizeMeetingNumber((string) $attendanceEvent->meeting_id);

        if (!$meetingNumber) {
            return back()->with('error', __('Zoom meeting number is invalid. Update the event meeting ID or recreate the Zoom meeting.'));
        }

        $setting = ZoomSyncSetting::firstOrNew(['workspace_id' => getActiveWorkSpace()]);

        return view('churchly::integrations.zoom_join', [
            'attendanceEvent' => $attendanceEvent,
            'zoomSetting' => $setting,
            'meetingSdkEnabled' => $zoomMeetingService->canUseMeetingSdk($setting),
            'canStartMeeting' => $this->userCanManageZoom($attendanceEvent) && !empty($attendanceEvent->host_start_url),
        ]);
    }

    public function signature(Request $request, int $attendanceEventId, ZoomMeetingService $zoomMeetingService): JsonResponse
    {
        $attendanceEvent = AttendanceEvent::where('workspace_id', getActiveWorkSpace())->findOrFail($attendanceEventId);

        $this->authorizeMeetingJoin($attendanceEvent);

        if (!$attendanceEvent->meeting_id) {
            return response()->json(['message' => 'Zoom meeting is not configured for this event.'], 422);
        }

        $meetingNumber = $this->normalizeMeetingNumber((string) $attendanceEvent->meeting_id);

        if (!$meetingNumber) {
            return response()->json([
                'message' => 'Zoom meeting number is invalid. Use numeric meeting ID only or recreate the Zoom meeting.',
            ], 422);
        }

        $setting = ZoomSyncSetting::firstOrNew(['workspace_id' => getActiveWorkSpace()]);

        try {
            $signature = $zoomMeetingService->makeMeetingSdkSignature($setting, $meetingNumber, 0);
        } catch (\Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json([
            'signature' => $signature,
            'sdkKey' => $setting->meeting_sdk_key,
            'meetingNumber' => $meetingNumber,
            'password' => $attendanceEvent->meeting_passcode,
            'userName' => Auth::user()?->name ?: 'Church Member',
            'userEmail' => Auth::user()?->email,
        ]);
    }

    protected function resolveAttendanceEvent(Event $event): AttendanceEvent
    {
        $attendanceEvent = $event->attendanceEvents()->first();

        if ($attendanceEvent) {
            $enabledMethods = collect($attendanceEvent->enabled_methods ?? [])->push('zoom')->unique()->values()->all();

            $attendanceEvent->forceFill([
                'mode' => $attendanceEvent->mode === 'onsite' ? 'online' : $attendanceEvent->mode,
                'online_platform' => 'zoom',
                'auto_log_attendance' => true,
                'enabled_methods' => $enabledMethods,
            ])->save();

            return $attendanceEvent;
        }

        return AttendanceEvent::create([
            'workspace_id' => getActiveWorkSpace(),
            'branch_id' => null,
            'department_id' => null,
            'event_id' => $event->id,
            'mode' => 'online',
            'enabled_methods' => ['zoom'],
            'online_platform' => 'zoom',
            'auto_log_attendance' => true,
            'created_by' => Auth::id(),
        ]);
    }

    protected function authorizeMeetingCreation(AttendanceEvent $attendanceEvent): void
    {
        abort_unless($this->userCanManageZoom($attendanceEvent), 403, __('You are not allowed to create Zoom meetings for this event.'));
    }

    protected function authorizeMeetingJoin(AttendanceEvent $attendanceEvent): void
    {
        abort_unless(Auth::check(), 403);
        abort_if(!$attendanceEvent->meeting_id, 404, __('Zoom meeting not found for this event.'));
    }

    protected function userCanManageZoom(?AttendanceEvent $attendanceEvent = null): bool
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

        return DB::table('church_member_department as member_department')
            ->leftJoin('church_designations as designations', 'designations.id', '=', 'member_department.designation_id')
            ->where('member_department.church_member_id', $churchMember->id)
            ->where('member_department.department_id', $departmentId)
            ->where(function ($query) use ($leaderKeywords) {
                foreach ($leaderKeywords as $keyword) {
                    $query->orWhere('designations.name', 'like', '%' . $keyword . '%');
                }
            })
            ->exists();
    }

    protected function normalizeMeetingNumber(string $meetingId): ?string
    {
        $digitsOnly = preg_replace('/\D+/', '', trim($meetingId));

        if (!$digitsOnly || strlen($digitsOnly) < 9) {
            return null;
        }

        return $digitsOnly;
    }
}
