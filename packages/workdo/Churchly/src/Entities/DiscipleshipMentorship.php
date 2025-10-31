<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscipleshipMentorship extends Model
{
    use HasFactory;

    protected $table = 'discipleship_mentorships';

    protected $fillable = [
        'mentor_id',
        'member_id',
        'status',
        'workspace',
    ];

    public function mentor()
    {
        return $this->belongsTo(\App\Models\User::class, 'mentor_id');
    }

    public function member()
    {
        return $this->belongsTo(ChurchMember::class, 'member_id');
    }
}
