<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChurchActivityLog extends Model
{
    use HasFactory;

    protected $table = 'church_activity_logs';

    protected $fillable = [
        'member_id',
        'user_id',
        'activity_type',
        'title',
        'description',
        'metadata',
        'status',
        'ip_address',
        'device',
        'location',
        'workspace',
        'created_by',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function member()
    {
        return $this->belongsTo(ChurchMember::class, 'member_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
