<?php

namespace Workdo\ChurchMeet\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Workdo\ChurchMeet\Entities\AttendanceEvent;
use Workdo\ChurchMeet\Entities\AttendanceRecord;
use Workdo\ChurchMeet\Entities\ChurchMember;
use Workdo\ChurchMeet\Entities\Event;

class AttendanceEventController extends Controller
{
    public function index()
    {
        $attendanceEvents = $this->visibleAttendanceEventsQuery(['event', 'occurrence'])
            ->orderByRaw('CASE WHEN checkin_start_at IS NULL THEN 1 ELSE 0 END')
            ->orderByDesc('checkin_start_at')
            ->orderByDesc('created_at')
            ->paginate(20);

        $recentAttendance = $this->visibleAttendanceEventsQuery(['event', 'occurrence'])
            ->orderByRaw('CASE WHEN checkin_start_at IS NULL THEN 1 ELSE 0 END')
            ->orderByDesc('checkin_start_at')
            ->orderByDesc('created_at')
            ->get();

        return view('churchmeet::attendance.attendance_events.index', compact('attendanceEvents', 'recentAttendance'));
    }

    public function create()
    {
        $selectedOccurrenceId = (int) request('occurrence_id');
        $selectedEventId = (int) request('event_id');

        $events = $this->visibleEventsQuery(['occurrences.attendanceEvent'])
            ->orderByRaw('CASE WHEN start_time IS NULL THEN 1 ELSE 0 END')
            ->orderByDesc('start_time')
            ->orderByDesc('created_at')
            ->get();

        $occurrences = $events->flatMap(function (Event $event) {
            return $event->occurrences
                ->where('is_cancelled', false)
                ->map(function ($occurrence) use ($event) {
                    $startsAt = $occurrence->starts_at;

                    return (object) [
                        'id' => $occurrence->id,
                        'event_id' => $event->id,
                        'title' => $event->title,
                        'sequence' => $occurrence->sequence,
                        'date_label' => $startsAt ? $startsAt->format('M d, Y h:i A') : __('No scheduled date'),
                        'is_past' => $startsAt ? $startsAt->isPast() : false,
                        'has_session' => (bool) $occurrence->attendanceEvent,
                        'sort_at' => $startsAt?->timestamp ?? 0,
                    ];
                });
        })
            ->sortByDesc('sort_at')
            ->values();

        if (!$selectedOccurrenceId && $selectedEventId) {
            $selectedOccurrenceId = (int) optional(
                $occurrences
                    ->where('event_id', $selectedEventId)
                    ->sortBy('sort_at')
                    ->first(fn ($occurrence) => !$occurrence->is_past)
            )->id;

            if (!$selectedOccurrenceId) {
                $selectedOccurrenceId = (int) optional($occurrences->firstWhere('event_id', $selectedEventId))->id;
            }
        }

        return view('churchmeet::attendance.attendance_events.create', compact('occurrences', 'selectedOccurrenceId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'occurrence_id' => 'required|integer',
            'mode' => 'required|string|in:onsite,online,hybrid',
            'checkin_start_at' => 'nullable|date',
            'checkin_end_at' => 'nullable|date|after_or_equal:checkin_start_at',
        ]);

        $occurrenceId = (int) $request->occurrence_id;
        $event = $this->visibleEventsQuery(['occurrences'])
            ->whereHas('occurrences', function (Builder $query) use ($occurrenceId) {
                $query->where('church_event_occurrences.id', $occurrenceId);
            })
            ->firstOrFail();

        $occurrence = $event->occurrences->firstWhere('id', $occurrenceId);
        abort_unless($occurrence, 404);

        $existingAttendanceEvent = $this->visibleAttendanceEventsQuery()
            ->where('occurrence_id', $occurrence->id)
            ->first();

        if ($existingAttendanceEvent) {
            return redirect()
                ->route('churchmeet.attendance_events.edit', $existingAttendanceEvent->id)
                ->with('info', __('Attendance tracking is already linked to the selected occurrence. The existing session has been opened so you can keep using the same records.'));
        }

        $attendanceEvent = AttendanceEvent::create([
            'checkin_start_at' => $request->checkin_start_at ?: $occurrence->starts_at ?: $event->start_time,
            'checkin_end_at' => $request->checkin_end_at ?: $occurrence->ends_at ?: $event->end_time,
            'workspace_id' => getActiveWorkSpace(),
            'branch_id' => $request->branch_id,
            'department_id' => $request->department_id,
            'event_id' => $event->id,
            'occurrence_id' => $occurrence->id,
            'mode' => $request->mode,
            'enabled_methods' => $request->enabled_methods ?? [],
            'online_platform' => $request->online_platform,
            'meeting_link' => $request->meeting_link,
            'meeting_id' => $request->meeting_id,
            'meeting_passcode' => $request->meeting_passcode,
            'auto_log_attendance' => (bool) ($request->auto_log_attendance ?? false),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('churchmeet.attendance_events.edit', $attendanceEvent->id)
            ->with('success', __('Attendance event created successfully.'));
    }

    public function edit($id)
    {
        $attendanceEvent = $this->visibleAttendanceEventsQuery(['event', 'occurrence'])->findOrFail($id);

        return view('churchmeet::attendance.attendance_events.edit', compact('attendanceEvent'));
    }

    public function update(Request $request, $id)
    {
        $attendanceEvent = $this->visibleAttendanceEventsQuery(['occurrence'])->findOrFail($id);

        $request->validate([
            'mode' => 'required|string|in:onsite,online,hybrid',
            'checkin_start_at' => 'nullable|date',
            'checkin_end_at' => 'nullable|date|after_or_equal:checkin_start_at',
        ]);

        $attendanceEvent->update([
            'checkin_start_at' => $request->checkin_start_at ?: $attendanceEvent->occurrence?->starts_at,
            'checkin_end_at' => $request->checkin_end_at ?: $attendanceEvent->occurrence?->ends_at,
            'branch_id' => $request->branch_id,
            'department_id' => $request->department_id,
            'mode' => $request->mode,
            'enabled_methods' => $request->enabled_methods ?? [],
            'online_platform' => $request->online_platform,
            'meeting_link' => $request->meeting_link,
            'meeting_id' => $request->meeting_id,
            'meeting_passcode' => $request->meeting_passcode,
            'auto_log_attendance' => (bool) ($request->auto_log_attendance ?? false),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('churchmeet.attendance_events.index')
            ->with('success', __('Attendance event updated successfully.'));
    }

    public function show($id)
    {
        $attendanceEvent = $this->visibleAttendanceEventsQuery(['event', 'occurrence', 'records'])
            ->findOrFail($id);

        return view('churchmeet::attendance.attendance_events.show', compact('attendanceEvent'));
    }

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
