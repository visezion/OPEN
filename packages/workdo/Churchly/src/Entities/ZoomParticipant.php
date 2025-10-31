<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ZoomParticipant extends Model
{
    protected $table = 'zoom_participants';

    protected $fillable = [
        'workspace_id','meeting_id','meeting_uuid','attendance_event_id','member_id','user_email','user_name','zoom_user_id','join_time','leave_time','duration','raw_json',
    ];

    protected $casts = [
        'join_time' => 'datetime',
        'leave_time' => 'datetime',
    ];
}

