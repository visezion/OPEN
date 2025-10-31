<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ChurchAppFeature extends Model
{
    protected $table = 'church_app_features';

    protected $fillable = ['workspace_id','feature_key','enabled','config','sort_order'];

    protected $casts = ['enabled'=>'boolean','config'=>'array'];

    public function scopeForWorkspace($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }
}
