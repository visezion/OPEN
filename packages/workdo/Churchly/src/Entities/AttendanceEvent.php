<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class AttendanceEvent extends Model
{
    protected $table = 'attendance_events';

    protected $fillable = [
        'workspace_id',
        'branch_id',
        'department_id',
        'event_id',
        'mode',
        'checkin_start_at',
        'checkin_end_at',
        'enabled_methods',
        'online_platform',
        'meeting_link',
        'meeting_id',
        'meeting_passcode',
        'auto_log_attendance',
        'qr_code',
        'face_ai_enabled',
        'created_by',
    ];

    protected $casts = [
        'enabled_methods' => 'array',
        'face_ai_enabled' => 'boolean',
        'auto_log_attendance' => 'boolean',
        'checkin_start_at' => 'datetime',
        'checkin_end_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function records()
    {
        return $this->hasMany(AttendanceRecord::class, 'attendance_event_id');
    }
}
