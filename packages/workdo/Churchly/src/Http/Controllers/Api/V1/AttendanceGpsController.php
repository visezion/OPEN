<?php

namespace Workdo\Churchly\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Workdo\Churchly\Entities\{AttendanceEvent, AttendanceRecord};

class AttendanceGpsController extends Controller
{
    public function checkin(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'platform' => 'nullable|in:mobile,web',
        ]);
        $memberId = Auth::user()->member->id ?? Auth::id();
        $attendanceEvent = AttendanceEvent::with('event')->find($data['event_id']);
        if (!$attendanceEvent || !$attendanceEvent->event) {
            return response()->json(['status'=>'error','message'=>'Event not found'],404);
        }
        $lat = (float) $data['latitude'];
        $lng = (float) $data['longitude'];
        // Round for privacy
        $lat = round($lat, 4); $lng = round($lng, 4);
        $ev = $attendanceEvent->event;
        $evLat = (float) ($ev->latitude ?? 0); $evLng = (float) ($ev->longitude ?? 0);
        $radius = (int) ($ev->radius_meters ?? 100);
        // Gating: ensure GPS method allowed if configured
        $methods = $attendanceEvent->enabled_methods ?? [];
        if (is_array($methods) && count($methods) > 0 && !in_array('gps', $methods)) {
            return response()->json(['status'=>'error','message'=>'GPS check-in is disabled for this event'], 403);
        }
        // Time window enforcement if configured
        if ($attendanceEvent->checkin_start_at || $attendanceEvent->checkin_end_at) {
            $now = now();
            if ($attendanceEvent->checkin_start_at && $now->lt($attendanceEvent->checkin_start_at)) {
                return response()->json([
                    'status'=>'error',
                    'message'=>'Check-in has not opened yet',
                    'window'=>[
                        'start'=>optional($attendanceEvent->checkin_start_at)->toIso8601String(),
                        'end'=>optional($attendanceEvent->checkin_end_at)->toIso8601String(),
                    ],
                ], 422);
            }
            if ($attendanceEvent->checkin_end_at && $now->gt($attendanceEvent->checkin_end_at)) {
                return response()->json([
                    'status'=>'error',
                    'message'=>'Check-in window has closed',
                    'window'=>[
                        'start'=>optional($attendanceEvent->checkin_start_at)->toIso8601String(),
                        'end'=>optional($attendanceEvent->checkin_end_at)->toIso8601String(),
                    ],
                ], 422);
            }
        }
        if (!$evLat || !$evLng) {
            return response()->json(['status'=>'error','message'=>'Event location not configured'],422);
        }
        $distance = $this->haversineMeters($lat,$lng,$evLat,$evLng);
        if ($distance <= $radius) {
            AttendanceRecord::updateOrCreate([
                'attendance_event_id' => $attendanceEvent->id,
                'member_id' => $memberId,
            ], [
                'workspace_id' => $attendanceEvent->workspace_id,
                'status' => 'present',
                'check_in_time' => now(),
                'device_used' => $data['platform'] === 'web' ? 'web_gps' : 'gps',
                'check_in_lat' => $lat,
                'check_in_lng' => $lng,
                'distance_from_event' => round($distance,1),
            ]);
            return response()->json(['status'=>'success','message'=>'Attendance marked successfully','distance'=>round($distance,1)]);
        }
        return response()->json(['status'=>'error','message'=>'You are '.round($distance,1).' meters away from the event venue','distance'=>round($distance,1)], 422);
    }

    protected function haversineMeters($lat1,$lon1,$lat2,$lon2): float
    {
        $R = 6371000; // meters
        $phi1 = deg2rad($lat1); $phi2 = deg2rad($lat2);
        $dphi = deg2rad($lat2 - $lat1); $dlambda = deg2rad($lon2 - $lon1);
        $a = sin($dphi/2)**2 + cos($phi1)*cos($phi2)*sin($dlambda/2)**2;
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $R * $c;
    }
}
