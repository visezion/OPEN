<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class MaintenanceCategory extends Model
{
    protected $table = 'maintenance_categories';

    protected $fillable = [
        'workspace_id',
        'name',
        'slug',
        'created_by',
        'updated_by',
    ];

    public function scopeForWorkspace($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }
}
