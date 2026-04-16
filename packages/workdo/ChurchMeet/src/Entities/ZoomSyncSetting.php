<?php

namespace Workdo\ChurchMeet\Entities;

use Illuminate\Database\Eloquent\Model;

class ZoomSyncSetting extends Model
{
    protected $table = 'zoom_sync_settings';

    protected $fillable = [
        'workspace_id',
        'preferred_platform',
        'jitsi_enabled',
        'jitsi_server_domain',
        'jitsi_room_prefix',
        'livekit_enabled',
        'livekit_server_url',
        'livekit_api_key',
        'livekit_api_secret',
        'livekit_room_prefix',
        'livekit_token_ttl_minutes',
        'account_id',
        'client_id',
        'client_secret',
        'host_user_id',
        'meeting_sdk_key',
        'meeting_sdk_secret',
        'oauth_access_token',
        'oauth_refresh_token',
        'token_expires_at',
        'active',
        'interval_minutes',
        'last_synced_at',
        'webhook_secret',
    ];

    protected $casts = [
        'active' => 'boolean',
        'jitsi_enabled' => 'boolean',
        'livekit_enabled' => 'boolean',
        'livekit_token_ttl_minutes' => 'integer',
        'token_expires_at' => 'datetime',
        'last_synced_at' => 'datetime',
    ];
}

