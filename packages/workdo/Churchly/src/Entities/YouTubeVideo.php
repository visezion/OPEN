<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class YouTubeVideo extends Model
{
    protected $table = 'youtube_videos';

    protected $fillable = [
        'workspace_id','youtube_video_id','channel_id','title','description','thumbnail_url','duration','live_broadcast_content','published_at','raw_json',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}

