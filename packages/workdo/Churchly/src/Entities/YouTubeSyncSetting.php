<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class YouTubeSyncSetting extends Model
{
    protected $table = 'youtube_sync_settings';

    protected $fillable = [
        'workspace_id','channel_id','playlist_id','mode','interval_minutes','api_key','active','last_synced_at',
    ];

    protected $casts = [
        'active' => 'boolean',
        'last_synced_at' => 'datetime',
    ];
}

