<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ChurchAppPublishSetting extends Model
{
    protected $table = 'church_app_publish_settings';

    protected $casts = [
        'android_store_connected'=>'boolean',
        'ios_store_connected'=>'boolean',
        'google_play_json'=>'array',
        'app_store_connect_json'=>'array',
        'store_links'=>'array',
    ];

    protected $fillable = [
        'workspace_id','android_store_connected','ios_store_connected',
        'google_play_json','app_store_connect_json','release_channel',
        'current_version','store_links'
    ];

    public function scopeForWorkspace($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }
}
