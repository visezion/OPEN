<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ChurchAppChangeLog extends Model
{
    protected $table = 'church_app_change_logs';

    protected $fillable = [
        'workspace_id','changed_by','section','before_json','after_json'
    ];

    protected $casts = ['before_json'=>'array','after_json'=>'array'];

    public function scopeForWorkspace($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }
}
