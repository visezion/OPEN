<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Workdo\Churchly\Entities\AttendanceRecord;
use Workdo\Churchly\Entities\AttendanceEvent;

class AttendanceRecordController extends Controller
{
    public function manualCheckIn(Request $request, $attendanceEventId)
    {
        $request->validate(['member_id' => 'required|integer']);
        
        AttendanceRecord::updateOrCreate(
            ['attendance_event_id' => $attendanceEventId, 'member_id' => $request->member_id],
            ['status' => 'present', 'check_in_time' => now(), 'device_used' => 'manual']
        );

        return back()->with('success', __('Member checked in manually.'));
    }

    public function qrCheckIn($attendanceEventId)
    {
        $memberId = Auth::user()->member->id ?? null;

        AttendanceRecord::updateOrCreate(
            ['attendance_event_id' => $attendanceEventId, 'member_id' => $memberId],
            ['status' => 'present', 'check_in_time' => now(), 'device_used' => 'qr']
        );

        return response()->json(['success' => true, 'msg' => 'QR Check-in successful']);
    }

    public function kioskCheckIn(Request $request, $attendanceEventId)
    {
        $request->validate(['member_id' => 'required|integer']);
        
        AttendanceRecord::updateOrCreate(
            ['attendance_event_id' => $attendanceEventId, 'member_id' => $request->member_id],
            ['status' => 'present', 'check_in_time' => now(), 'device_used' => 'kiosk']
        );

        return back()->with('success', __('Kiosk check-in successful.'));
    }

    public function faceAiCheckIn(Request $request, $attendanceEventId)
    {
        $response = Http::attach('image', $request->file('photo')->get(), 'face.jpg')
            ->post(env('FACE_AI_ENDPOINT').'/verify', [
                'member_id' => Auth::id(),
            ]);

        if ($response->ok() && $response->json('verified')) {
            AttendanceRecord::updateOrCreate(
                ['attendance_event_id' => $attendanceEventId, 'member_id' => Auth::id()],
                ['status' => 'present', 'check_in_time' => now(), 'device_used' => 'face_ai']
            );
            return back()->with('success', __('Facial recognition check-in successful.'));
        }

        return back()->with('error', __('Face not recognized.'));
    }

    public function searchMember(Request $request)
    {
        $term = $request->get('q');

        $members = \Workdo\Churchly\Entities\ChurchMember::query()
            ->when($term, function ($query, $term) {
                $query->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('phone', 'LIKE', "%{$term}%")
                    ->orWhere('id', $term);
            })
            ->limit(10)
            ->get();

        return response()->json($members->map(function($m) {
            return [
                'id' => $m->id,
                'name' => $m->name,
                'phone' => $m->phone,
            ];
        }));
    }




    public function onlineCheckIn($attendanceEventId)
    {
        AttendanceRecord::updateOrCreate(
            ['attendance_event_id' => $attendanceEventId, 'member_id' => Auth::id()],
            ['status' => 'present', 'check_in_time' => now(), 'device_used' => 'online']
        );

        return redirect()->back()->with('success', __('Online attendance recorded.'));
    }


    private function updateGamification($memberId, $attendanceEventId)
    {
        $attendanceEvent = AttendanceEvent::with('event')->findOrFail($attendanceEventId);
        $record = AttendanceRecord::where('attendance_event_id', $attendanceEventId)
            ->where('member_id', $memberId)
            ->first();

        if (!$record) {
            return;
        }

        // Base XP
        $xp = 10;

        // Bonus for on-time
        if ($attendanceEvent->event->start_time && $record->check_in_time) {
            if ($record->check_in_time <= $attendanceEvent->event->start_time) {
                $xp += 5;
            }
        }

        // Check last record for streak
        $lastRecord = AttendanceRecord::where('member_id', $memberId)
            ->where('id', '<', $record->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRecord && $lastRecord->status === 'present') {
            $record->streak_count = ($lastRecord->streak_count ?? 0) + 1;
            if ($record->streak_count % 3 === 0) {
                $xp += 20; // streak bonus
            }
        } else {
            $record->streak_count = 1;
        }

        $record->xp_points += $xp;
        $record->save();

        // Update leaderboard
        $this->updateLeaderboard($memberId, $record);
    }

    private function updateLeaderboard($memberId, $record)
    {
        $month = date('m', strtotime($record->check_in_time));
        $year = date('Y', strtotime($record->check_in_time));

        $leaderboard = AttendanceLeaderboard::firstOrNew([
            'workspace_id' => $record->workspace_id,
            'member_id' => $memberId,
            'month' => $month,
            'year' => $year,
        ]);

        $leaderboard->attendance_count = ($leaderboard->attendance_count ?? 0) + 1;
        $leaderboard->streak_longest = max($leaderboard->streak_longest ?? 0, $record->streak_count);
        $leaderboard->save();
    }


    private function syncDiscipleshipProgress($memberId, $attendanceEventId)
    {
        $attendanceEvent = AttendanceEvent::with('event')->findOrFail($attendanceEventId);
        $eventId = $attendanceEvent->event_id;

        // Check if this event is tied to any discipleship stage
        $stageEvents = \Workdo\Churchly\Entities\DiscipleshipStageEvent::where('event_id', $eventId)->get();

        foreach ($stageEvents as $stageEvent) {
            $progress = \Workdo\Churchly\Entities\DiscipleshipMemberProgress::firstOrNew([
                'member_id' => $memberId,
                'stage_id' => $stageEvent->stage_id,
                'workspace' => $attendanceEvent->workspace_id,
            ]);

            // Increment attendance count
            $progress->attended_events = ($progress->attended_events ?? 0) + 1;

            // Mark stage complete if required count met
            $requiredCount = $stageEvent->stage->required_event_count ?? 1;
            if ($progress->attended_events >= $requiredCount) {
                $progress->status = 'completed';
                $progress->completed_at = now();
            } else {
                $progress->status = 'in_progress';
            }

            $progress->save();
        }
    }

}
