<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Routing\Controller;
use Workdo\Churchly\Entities\AttendanceEvent;
use Workdo\Churchly\Entities\AttendanceRecord;
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

    public function dashboard()
    {
        $trend = AttendanceRecord::selectRaw('DATE(check_in_time) as day, COUNT(*) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $absentees = ChurchMember::withCount(['attendanceRecords as recent_absences' => function($q) {
            $q->where('status', 'absent')->where('check_in_time', '>=', now()->subWeeks(3));
        }])->get();

        return view('churchly::attendance.reports.dashboard', compact('trend','absentees'));
    }
}
