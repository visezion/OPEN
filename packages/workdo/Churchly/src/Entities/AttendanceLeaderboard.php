<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class AttendanceLeaderboard extends Model
{
    protected $table = 'attendance_leaderboards';

    protected $fillable = [
        'workspace_id',
        'member_id',
        'month',
        'year',
        'attendance_count',
        'streak_longest',
        'rank',
    ];

    public function member()
    {
        return $this->belongsTo(ChurchMember::class, 'member_id');
    }
}
