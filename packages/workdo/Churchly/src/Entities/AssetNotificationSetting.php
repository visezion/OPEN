<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class AssetNotificationSetting extends Model
{
    protected $table = 'asset_notification_settings';

    protected $fillable = [
        'workspace_id',
        'notification_methods',
        'notification_time',
        'low_stock_threshold',
        'inspection_reminder_days',
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
