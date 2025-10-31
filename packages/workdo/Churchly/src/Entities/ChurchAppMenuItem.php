<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ChurchAppMenuItem extends Model
{
    protected $table = 'church_app_menu_items';

    protected $fillable = [
        'workspace_id','title','feature_key','icon_name','target_type',
        'target_value','sort_order','visible'
    ];

    protected $casts = ['visible'=>'boolean'];

    public function scopeForWorkspace($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }
}
