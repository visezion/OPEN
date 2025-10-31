<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ZoomSyncSetting extends Model
{
    protected $table = 'zoom_sync_settings';

    protected $fillable = [
        'workspace_id','account_id','client_id','client_secret','oauth_access_token','oauth_refresh_token','token_expires_at','active','interval_minutes','last_synced_at','webhook_secret',
    ];

    protected $casts = [
        'active' => 'boolean',
        'token_expires_at' => 'datetime',
        'last_synced_at' => 'datetime',
    ];
}

