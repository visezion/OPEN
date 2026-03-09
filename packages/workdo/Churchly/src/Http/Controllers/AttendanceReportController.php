<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Workdo\Churchly\Entities\AttendanceEvent;
use Workdo\Churchly\Entities\AttendanceRecord;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\ChurchMember;

class AttendanceReportController extends Controller
{
    public function eventReport($attendanceEventId)
    {
        $attendanceEvent = AttendanceEvent::with('event','records.member')->findOrFail($attendanceEventId);
        return view('churchly::attendance.reports.event_report', compact('attendanceEvent'));
    }

    public function memberReport($memberId)
    {
        $member = ChurchMember::with('attendanceRecords.attendanceEvent.event')->findOrFail($memberId);
        return view('churchly::attendance.reports.member_report', compact('member'));
    }

    public function branchReport($branchId)
    {
        $attendance = AttendanceRecord::whereHas('attendanceEvent', function($q) use ($branchId) {
            $q->where('branch_id', $branchId);
        })->with('member')->get();

        return view('churchly::attendance.reports.branch_report', compact('attendance'));
    }

    public function dashboard(Request $request)
    {
        $monthInput = $request->input('month');
        $selectedMonth = $monthInput
            ? Carbon::createFromFormat('Y-m', $monthInput)->startOfMonth()
            : now()->startOfMonth();

        $monthStart = $selectedMonth->copy()->startOfMonth();
        $monthEnd = $selectedMonth->copy()->endOfMonth();
        $workspaceId = getActiveWorkSpace();

        $monthlyRecords = AttendanceRecord::query()
            ->where('workspace_id', $workspaceId)
            ->whereBetween('check_in_time', [$monthStart, $monthEnd]);

        $totalMembers = ChurchMember::forWorkspace($workspaceId)->count();
        $eventsHeld = AttendanceEvent::query()
            ->where('workspace_id', $workspaceId)
            ->whereBetween('checkin_start_at', [$monthStart, $monthEnd])
            ->count();
        $presentCount = (clone $monthlyRecords)->where('status', 'present')->count();
        $absentCount = (clone $monthlyRecords)->where('status', 'absent')->count();
        $lateCount = (clone $monthlyRecords)->where('status', 'late')->count();
        $excusedCount = (clone $monthlyRecords)->where('status', 'excused')->count();
        $totalRecords = $presentCount + $absentCount + $lateCount + $excusedCount;
        $attendanceRate = $totalRecords > 0 ? round((($presentCount + $lateCount) / $totalRecords) * 100, 1) : 0;

        $trend = AttendanceRecord::query()
            ->where('workspace_id', $workspaceId)
            ->whereBetween('check_in_time', [$monthStart, $monthEnd])
            ->selectRaw('DATE(check_in_time) as day')
            ->selectRaw("SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_total")
            ->selectRaw("SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late_total")
            ->selectRaw("SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_total")
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $eventPerformance = AttendanceEvent::query()
            ->where('workspace_id', $workspaceId)
            ->whereBetween('checkin_start_at', [$monthStart, $monthEnd])
            ->with(['event', 'records'])
            ->get()
            ->map(function ($attendanceEvent) {
                $records = $attendanceEvent->records;
                $present = $records->where('status', 'present')->count();
                $late = $records->where('status', 'late')->count();
                $absent = $records->where('status', 'absent')->count();
                $total = $records->count();

                return (object) [
                    'title' => $attendanceEvent->event->title ?? __('Untitled event'),
                    'date' => optional($attendanceEvent->checkin_start_at)->format('d M Y'),
                    'mode' => ucfirst($attendanceEvent->mode ?? 'in-person'),
                    'branch_id' => $attendanceEvent->branch_id,
                    'total' => $total,
                    'present' => $present,
                    'late' => $late,
                    'absent' => $absent,
                    'attendance_rate' => $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0,
                ];
            })
            ->sortByDesc('attendance_rate')
            ->values();

        $branches = ChurchBranch::query()
            ->where('workspace', $workspaceId)
            ->pluck('name', 'id');

        $branchBreakdown = AttendanceRecord::query()
            ->where('attendance_records.workspace_id', $workspaceId)
            ->whereBetween('attendance_records.check_in_time', [$monthStart, $monthEnd])
            ->leftJoin('church_members', 'church_members.id', '=', 'attendance_records.member_id')
            ->selectRaw('church_members.branch_id as branch_id, COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN attendance_records.status = 'present' THEN 1 ELSE 0 END) as present_total")
            ->selectRaw("SUM(CASE WHEN attendance_records.status = 'late' THEN 1 ELSE 0 END) as late_total")
            ->selectRaw("SUM(CASE WHEN attendance_records.status = 'absent' THEN 1 ELSE 0 END) as absent_total")
            ->groupBy('church_members.branch_id')
            ->get()
            ->map(function ($row) use ($branches) {
                $engaged = $row->present_total + $row->late_total;

                return (object) [
                    'branch' => $branches[$row->branch_id] ?? __('Unassigned'),
                    'total' => (int) $row->total,
                    'engaged' => (int) $engaged,
                    'absent' => (int) $row->absent_total,
                    'attendance_rate' => $row->total > 0 ? round(($engaged / $row->total) * 100, 1) : 0,
                ];
            })
            ->sortByDesc('total')
            ->values();

        $engagementRisks = ChurchMember::query()
            ->forWorkspace($workspaceId)
            ->with('branch')
            ->withCount(['attendanceRecords as monthly_absences' => function ($query) use ($monthStart, $monthEnd, $workspaceId) {
                $query->where('workspace_id', $workspaceId)
                    ->whereBetween('check_in_time', [$monthStart, $monthEnd])
                    ->where('status', 'absent');
            }])
            ->withCount(['attendanceRecords as monthly_present' => function ($query) use ($monthStart, $monthEnd, $workspaceId) {
                $query->where('workspace_id', $workspaceId)
                    ->whereBetween('check_in_time', [$monthStart, $monthEnd])
                    ->whereIn('status', ['present', 'late']);
            }])
            ->get()
            ->filter(function ($member) {
                return $member->monthly_absences > 0 || $member->monthly_present > 0;
            })
            ->sortByDesc('monthly_absences')
            ->take(8)
            ->values();

        $summary = [
            'month_label' => $selectedMonth->format('F Y'),
            'month_value' => $selectedMonth->format('Y-m'),
            'events_held' => $eventsHeld,
            'total_members' => $totalMembers,
            'attendance_rate' => $attendanceRate,
            'present_count' => $presentCount,
            'late_count' => $lateCount,
            'absent_count' => $absentCount,
            'excused_count' => $excusedCount,
            'total_records' => $totalRecords,
        ];

        return view('churchly::attendance.reports.dashboard', compact(
            'summary',
            'trend',
            'eventPerformance',
            'branchBreakdown',
            'engagementRisks'
        ));
    }
}
