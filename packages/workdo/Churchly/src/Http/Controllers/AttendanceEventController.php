<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\AttendanceEvent;
use Workdo\Churchly\Entities\Event;
use Workdo\Churchly\Entities\AttendanceRecord;
use Workdo\Churchly\Entities\ChurchMember;

class AttendanceEventController extends Controller
{
    public function index()
    {
        $attendanceEvents = AttendanceEvent::with('event')
            ->where('workspace_id', getActiveWorkSpace())
            ->latest()
            ->paginate(20);
        $recentAttendance = AttendanceEvent::where('workspace_id', getActiveWorkSpace())->orderBy('created_at', 'desc')->get();
        return view('churchly::attendance.attendance_events.index', compact('attendanceEvents','recentAttendance'));
    }

    public function create()
    {
        $events = Event::all();
        return view('churchly::attendance.attendance_events.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'mode' => 'required|string|in:onsite,online,hybrid',
            'checkin_start_at' => 'nullable|date',
            'checkin_end_at' => 'nullable|date|after_or_equal:checkin_start_at',
        ]);

        AttendanceEvent::create([
            'checkin_start_at' => $request->checkin_start_at,
            'checkin_end_at' => $request->checkin_end_at,
            'workspace_id' => getActiveWorkSpace(),
            'branch_id' => $request->branch_id,
            'department_id' => $request->department_id,
            'event_id' => $request->event_id,
            'mode' => $request->mode,
            'enabled_methods' => $request->enabled_methods ?? [],
            'online_platform' => $request->online_platform,
            'meeting_link' => $request->meeting_link,
            'meeting_id' => $request->meeting_id,
            'meeting_passcode' => $request->meeting_passcode,
            'auto_log_attendance' => (bool)($request->auto_log_attendance ?? false),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('churchly.attendance_events.index')
            ->with('success', __('Attendance event created successfully.'));
    }

    // Edit form
    public function edit($id)
    {
        $attendanceEvent = AttendanceEvent::findOrFail($id);
        $events = Event::all();

        return view('churchly::attendance.attendance_events.edit', compact('attendanceEvent', 'events'));
    }

    // Update existing record
    public function update(Request $request, $id)
    {
        $attendanceEvent = AttendanceEvent::findOrFail($id);

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

        return redirect()->route('churchly.attendance_events.index')
            ->with('success', __('Attendance event updated successfully.'));
    }

    public function show($id)
    {
        $attendanceEvent = AttendanceEvent::with('event','records')->findOrFail($id);
        return view('churchly::attendance.attendance_events.show', compact('attendanceEvent'));
    }

    // QR scanner
    public function showScanner($id)
    {
        $event = AttendanceEvent::findOrFail($id);
        return view('churchly::attendance.scanner', compact('event'));
    }

    public function markAttendance(Request $request, $id)
    {
        $request->validate(['qr' => 'required|string']);

        $event = AttendanceEvent::findOrFail($id);
        $data = json_decode($request->qr, true);

        if (!$data || !isset($data['member_id'])) {
            return response()->json(['ok' => false, 'error' => 'Invalid QR data.']);
        }

        $member = ChurchMember::find($data['member_id']);
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

