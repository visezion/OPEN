<?php

namespace Workdo\ChurchMeet\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Workdo\ChurchMeet\Entities\AttendanceEvent;
use Workdo\ChurchMeet\Entities\ChurchMember;
use Workdo\ChurchMeet\Entities\Event;
use Workdo\ChurchMeet\Entities\ZoomSyncSetting;
use Workdo\ChurchMeet\Services\ZoomMeetingService;

class ZoomMeetingController extends Controller
{
    public function createForEvent(int $eventId, ZoomMeetingService $zoomMeetingService)
    {
        $event = Event::with('attendanceEvents')->inWorkspace()->findOrFail($eventId);
        $attendanceEvent = $this->resolveAttendanceEvent($event);

        $this->authorizeMeetingCreation($attendanceEvent);

        $setting = ZoomSyncSetting::firstOrNew(['workspace_id' => $attendanceEvent->workspace_id]);

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

    public function join(Request $request, string $attendanceEventId, ZoomMeetingService $zoomMeetingService)
    {
        $attendanceEvent = $this->resolveJoinableAttendanceEvent($attendanceEventId);

        $this->authorizeMeetingJoin($attendanceEvent);
        $meetingNumber = $this->resolveMeetingNumber($attendanceEvent);

        if (!$meetingNumber) {
            return back()->with('error', __('Zoom meeting number is invalid. Update the event meeting details or recreate the Zoom meeting.'));
        }

        $setting = ZoomSyncSetting::firstOrNew(['workspace_id' => $attendanceEvent->workspace_id]);
        $guestDisplayName = $this->resolveParticipantDisplayName($request);

        return view('churchmeet::integrations.zoom_join', [
            'attendanceEvent' => $attendanceEvent,
            'zoomSetting' => $setting,
            'meetingSdkEnabled' => $zoomMeetingService->canUseMeetingSdk($setting),
            'canStartMeeting' => $this->userCanManageZoom($attendanceEvent) && !empty($attendanceEvent->host_start_url),
            'guestDisplayName' => $guestDisplayName,
            'requiresGuestName' => !Auth::check() && $guestDisplayName === '',
        ]);
    }

    public function signature(Request $request, string $attendanceEventId, ZoomMeetingService $zoomMeetingService): JsonResponse
    {
        $attendanceEvent = $this->resolveJoinableAttendanceEvent($attendanceEventId);

        $this->authorizeMeetingJoin($attendanceEvent);
        $meetingNumber = $this->resolveMeetingNumber($attendanceEvent);

        if (!$meetingNumber) {
            return response()->json([
                'message' => 'Zoom meeting number is invalid. Update the event meeting details or recreate the Zoom meeting.',
            ], 422);
        }

        $displayName = $this->resolveParticipantDisplayName($request);
        if (!Auth::check() && $displayName === '') {
            return response()->json([
                'message' => 'Enter your display name before joining this meeting.',
            ], 422);
        }

        $setting = ZoomSyncSetting::firstOrNew(['workspace_id' => $attendanceEvent->workspace_id]);

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
            'userName' => $displayName,
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
        abort_if(!$this->resolveMeetingNumber($attendanceEvent), 404, __('Zoom meeting not found for this event.'));
    }

    protected function resolveJoinableAttendanceEvent(string $attendanceEventId): AttendanceEvent
    {
        $resolvedId = AttendanceEvent::decodePublicJoinKey($attendanceEventId);
        abort_if(!$resolvedId, 404, __('Meeting link is invalid.'));

        return AttendanceEvent::with('event')->findOrFail($resolvedId);
    }

    protected function resolveParticipantDisplayName(Request $request): string
    {
        if (Auth::check()) {
            return Auth::user()?->name ?: 'Church Member';
        }

        $sessionKey = 'churchmeet_guest_display_name';
        $requestedName = trim((string) $request->query('guest_name', $request->input('guest_name', '')));

        if ($requestedName !== '') {
            $normalizedName = \Illuminate\Support\Str::limit($requestedName, 60, '');
            $request->session()->put($sessionKey, $normalizedName);

            return $normalizedName;
        }

        $storedName = trim((string) $request->session()->get($sessionKey, ''));
        return $storedName;
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

    protected function resolveMeetingNumber(AttendanceEvent $attendanceEvent): ?string
    {
        $fromJoinUrl = $this->extractMeetingNumberFromUrl((string) $attendanceEvent->zoom_join_url);
        if ($fromJoinUrl) {
            return $fromJoinUrl;
        }

        $fromMeetingLink = $this->extractMeetingNumberFromUrl((string) $attendanceEvent->meeting_link);
        if ($fromMeetingLink) {
            return $fromMeetingLink;
        }

        return $this->normalizeMeetingNumber((string) $attendanceEvent->meeting_id);
    }

    protected function extractMeetingNumberFromUrl(string $url): ?string
    {
        if ($url === '') {
            return null;
        }

        $path = (string) parse_url($url, PHP_URL_PATH);

        if ($path !== '' && preg_match('#/(?:j|wc|s)/(\d{9,})#', $path, $matches)) {
            return $matches[1];
        }

        if (preg_match('/(?:[?&](?:meetingNumber|meeting_id|mn)=)(\d{9,})/i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}

