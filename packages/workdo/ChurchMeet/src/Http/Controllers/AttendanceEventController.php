<?php

namespace Workdo\ChurchMeet\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Workdo\ChurchMeet\Entities\AttendanceEvent;
use Workdo\ChurchMeet\Entities\Event;
use Workdo\ChurchMeet\Entities\AttendanceRecord;
use Workdo\ChurchMeet\Entities\ChurchMember;

class AttendanceEventController extends Controller
{
    public function index()
    {
        $attendanceEvents = $this->visibleAttendanceEventsQuery(['event'])
            ->latest()
            ->paginate(20);
        $recentAttendance = $this->visibleAttendanceEventsQuery(['event'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('churchmeet::attendance.attendance_events.index', compact('attendanceEvents','recentAttendance'));
    }

    public function create()
    {
        $selectedEventId = (int) request('event_id');
        $events = $this->visibleEventsQuery()
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
        $event = $this->visibleEventsQuery()
            ->findOrFail((int) $request->event_id);

        $existingAttendanceEvent = $this->visibleAttendanceEventsQuery()
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
        $attendanceEvent = $this->visibleAttendanceEventsQuery()->findOrFail($id);
        $events = $this->visibleEventsQuery()
            ->orderByRaw('CASE WHEN start_time IS NULL THEN 1 ELSE 0 END')
            ->orderByDesc('start_time')
            ->orderByDesc('created_at')
            ->get();

        return view('churchmeet::attendance.attendance_events.edit', compact('attendanceEvent', 'events'));
    }

    // Update existing record
    public function update(Request $request, $id)
    {
        $attendanceEvent = $this->visibleAttendanceEventsQuery()->findOrFail($id);

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
        $attendanceEvent = $this->visibleAttendanceEventsQuery(['event', 'records'])
            ->findOrFail($id);
        return view('churchmeet::attendance.attendance_events.show', compact('attendanceEvent'));
    }

    // QR scanner
    public function showScanner($id)
    {
        $event = $this->visibleAttendanceEventsQuery()->findOrFail($id);
        return view('churchmeet::attendance.scanner', compact('event'));
    }

    public function markAttendance(Request $request, $id)
    {
        $request->validate(['qr' => 'required|string']);

        $event = $this->visibleAttendanceEventsQuery()->findOrFail($id);
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

    protected function visibleAttendanceEventsQuery(array $with = []): Builder
    {
        $query = AttendanceEvent::query()
            ->where('workspace_id', getActiveWorkSpace());

        if (!empty($with)) {
            $query->with($with);
        }

        $user = Auth::user();

        if (!$user) {
            return $query->whereRaw('1 = 0');
        }

        $member = ChurchMember::forWorkspace()
            ->with('departments')
            ->where('user_id', $user->id)
            ->first();

        $memberId = $member?->id;
        $branchId = $member?->branch_id;
        $departmentIds = $member
            ? $member->departments->pluck('id')->filter()->values()->all()
            : [];

        return $query->where(function (Builder $visibleQuery) use ($user, $memberId, $branchId, $departmentIds) {
            $visibleQuery->where('created_by', $user->id)
                ->orWhereHas('event', function (Builder $eventQuery) use ($user, $memberId) {
                    $eventQuery->where(function (Builder $eventVisibleQuery) use ($user, $memberId) {
                        $eventVisibleQuery->where('created_by', $user->id);

                        if ($memberId) {
                            $eventVisibleQuery->orWhere('lead_id', $memberId)
                                ->orWhere('assistant_id', $memberId)
                                ->orWhereHas('programs', function (Builder $programQuery) use ($memberId) {
                                    $programQuery->where('leader_id', $memberId);
                                });
                        }
                    });
                })
                ->orWhere(function (Builder $scopeQuery) use ($branchId, $departmentIds) {
                    $scopeQuery->whereNull('branch_id')
                        ->whereNull('department_id');

                    if (!empty($departmentIds)) {
                        $scopeQuery->orWhereIn('department_id', $departmentIds);
                    }

                    if ($branchId) {
                        $scopeQuery->orWhere('branch_id', $branchId);
                    }
                });
        });
    }

    protected function visibleEventsQuery(array $with = []): Builder
    {
        $query = Event::query()->inWorkspace();

        if (!empty($with)) {
            $query->with($with);
        }

        $user = Auth::user();

        if (!$user) {
            return $query->whereRaw('1 = 0');
        }

        $member = ChurchMember::forWorkspace()
            ->with('departments')
            ->where('user_id', $user->id)
            ->first();

        $memberId = $member?->id;
        $branchId = $member?->branch_id;
        $departmentIds = $member
            ? $member->departments->pluck('id')->filter()->values()->all()
            : [];

        return $query->where(function (Builder $visibleQuery) use ($user, $memberId, $branchId, $departmentIds) {
            $visibleQuery->where('created_by', $user->id);

            if ($memberId) {
                $visibleQuery->orWhere('lead_id', $memberId)
                    ->orWhere('assistant_id', $memberId)
                    ->orWhereHas('programs', function (Builder $programQuery) use ($memberId) {
                        $programQuery->where('leader_id', $memberId);
                    });
            }

            $visibleQuery->orWhereHas('attendanceEvents', function (Builder $attendanceQuery) use ($branchId, $departmentIds) {
                $attendanceQuery->where(function (Builder $scopeQuery) use ($branchId, $departmentIds) {
                    $scopeQuery->where(function (Builder $globalQuery) {
                        $globalQuery->whereNull('branch_id')
                            ->whereNull('department_id');
                    });

                    if (!empty($departmentIds)) {
                        $scopeQuery->orWhereIn('department_id', $departmentIds);
                    }

                    if ($branchId) {
                        $scopeQuery->orWhere('branch_id', $branchId);
                    }
                });
            });
        });
    }
}


