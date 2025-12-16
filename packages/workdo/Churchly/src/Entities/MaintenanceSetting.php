<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class MaintenanceSetting extends Model
{
    protected $table = 'maintenance_settings';

    protected $fillable = [
        'workspace_id',
        'notification_methods',
        'notification_time',
        'reminder_before_days',
        'default_category',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'notification_methods' => 'array',
    ];

    public function scopeForWorkspace($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }
}
