<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $table = 'attendance_records';

    protected $fillable = [
        'workspace_id',
        'attendance_event_id',
        'member_id',
        'status',
        'check_in_time',
        'check_out_time',
        'device_used',
        'streak_count',
        'xp_points',
        'reviewed_by',
        'check_in_lat',
        'check_in_lng',
        'distance_from_event',
    ];

    public function attendanceEvent()
    {
        return $this->belongsTo(AttendanceEvent::class, 'attendance_event_id');
    }

    public function member()
    {
        return $this->belongsTo(ChurchMember::class, 'member_id');
    }
}
