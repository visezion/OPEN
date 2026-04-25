<?php

namespace Workdo\ChurchMeet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\ChurchMeet\Entities\AttendanceEvent;
use Workdo\ChurchMeet\Entities\Event;
use Workdo\ChurchMeet\Entities\AttendanceRecord;
use Workdo\ChurchMeet\Entities\ChurchMember;

class AttendanceEventController extends Controller
{
    public function index()
    {
        $attendanceEvents = AttendanceEvent::with('event')
            ->where('workspace_id', getActiveWorkSpace())
            ->latest()
            ->paginate(20);
        $recentAttendance = AttendanceEvent::where('workspace_id', getActiveWorkSpace())->orderBy('created_at', 'desc')->get();
        return view('churchmeet::attendance.attendance_events.index', compact('attendanceEvents','recentAttendance'));
    }

    public function create()
    {
        $selectedEventId = (int) request('event_id');
        $events = Event::query()
            ->inWorkspace()
            ->withCount('attendanceEvents')
            ->orderByRaw('CASE WHEN start_time IS NULL THEN 1 ELSE 0 END')
            ->orderByDesc('start_time')
            ->orderByDesc('created_at')
            ->get();

        return view('churchmeet::attendance.attendance_events.create', compact('events', 'selectedEventId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer',
            'mode' => 'required|string|in:onsite,online,hybrid',
            'checkin_start_at' => 'nullable|date',
            'checkin_end_at' => 'nullable|date|after_or_equal:checkin_start_at',
        ]);

        $workspaceId = getActiveWorkSpace();
        $event = Event::query()
            ->inWorkspace()
            ->findOrFail((int) $request->event_id);

        $existingAttendanceEvent = AttendanceEvent::query()
            ->where('workspace_id', $workspaceId)
            ->where('event_id', $event->id)
            ->first();

        if ($existingAttendanceEvent) {
            return redirect()
                ->route('churchmeet.attendance_events.edit', $existingAttendanceEvent->id)
                ->with('info', __('Attendance tracking is already linked to ":event". The existing session has been opened so you can keep using the same records.', [
                    'event' => $event->title,
                ]));
        }

        $attendanceEvent = AttendanceEvent::create([
            'checkin_start_at' => $request->checkin_start_at ?: $event->start_time,
            'checkin_end_at' => $request->checkin_end_at ?: $event->end_time,
            'workspace_id' => $workspaceId,
            'branch_id' => $request->branch_id,
            'department_id' => $request->department_id,
            'event_id' => $event->id,
            'mode' => $request->mode,
            'enabled_methods' => $request->enabled_methods ?? [],
            'online_platform' => $request->online_platform,
            'meeting_link' => $request->meeting_link,
            'meeting_id' => $request->meeting_id,
            'meeting_passcode' => $request->meeting_passcode,
            'auto_log_attendance' => (bool)($request->auto_log_attendance ?? false),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('churchmeet.attendance_events.edit', $attendanceEvent->id)
            ->with('success', __('Attendance event created successfully.'));
    }

    // Edit form
    public function edit($id)
    {
        $attendanceEvent = AttendanceEvent::where('workspace_id', getActiveWorkSpace())->findOrFail($id);
        $events = Event::query()
            ->inWorkspace()
            ->orderByRaw('CASE WHEN start_time IS NULL THEN 1 ELSE 0 END')
            ->orderByDesc('start_time')
            ->orderByDesc('created_at')
            ->get();

        return view('churchmeet::attendance.attendance_events.edit', compact('attendanceEvent', 'events'));
    }

    // Update existing record
    public function update(Request $request, $id)
    {
        $attendanceEvent = AttendanceEvent::where('workspace_id', getActiveWorkSpace())->findOrFail($id);

        $request->validate([
            'mode' => 'required|string|in:onsite,online,hybrid',
            'checkin_start_at' => 'nullable|date',
            'checkin_end_at' => 'nullable|date|after_or_equal:checkin_start_at',
        ]);

        $attendanceEvent->update([
            'checkin_start_at' => $request->checkin_start_at,
            'checkin_end_at' => $request->checkin_end_at,
            'branch_id' => $request->branch_id,
            'department_id' => $request->department_id,
            'mode' => $request->mode,
            'enabled_methods' => $request->enabled_methods ?? [],
            'online_platform' => $request->online_platform,
            'meeting_link' => $request->meeting_link,
            'meeting_id' => $request->meeting_id,
            'meeting_passcode' => $request->meeting_passcode,
            'auto_log_attendance' => (bool)($request->auto_log_attendance ?? false),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('churchmeet.attendance_events.index')
            ->with('success', __('Attendance event updated successfully.'));
    }

    public function show($id)
    {
        $attendanceEvent = AttendanceEvent::with('event','records')
            ->where('workspace_id', getActiveWorkSpace())
            ->findOrFail($id);
        return view('churchmeet::attendance.attendance_events.show', compact('attendanceEvent'));
    }

    // QR scanner
    public function showScanner($id)
    {
        $event = AttendanceEvent::where('workspace_id', getActiveWorkSpace())->findOrFail($id);
        return view('churchmeet::attendance.scanner', compact('event'));
    }

    public function markAttendance(Request $request, $id)
    {
        $request->validate(['qr' => 'required|string']);

        $event = AttendanceEvent::where('workspace_id', getActiveWorkSpace())->findOrFail($id);
        $data = json_decode($request->qr, true);

        if (!$data || !isset($data['member_id'])) {
            return response()->json(['ok' => false, 'error' => 'Invalid QR data.']);
        }

        $member = ChurchMember::forWorkspace()->find($data['member_id']);
        if (!$member) {
            return response()->json(['ok' => false, 'error' => 'Member not found.']);
        }

        $record = AttendanceRecord::firstOrCreate(
            [
                'attendance_event_id' => $event->id,
                'member_id' => $member->id,
                'workspace_id' => $member->workspace,
            ],
            [
                'status' => 'present',
                'check_in_time' => now(),
                'device_used' => 'qr',
                'created_at' => now(),
            ]
        );

        return response()->json([
            'ok' => true,
            'message' => "{$member->name} marked present!",
            'record_id' => $record->id,
        ]);
    }
}


