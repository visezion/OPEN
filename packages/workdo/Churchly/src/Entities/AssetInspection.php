<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetInspection extends Model
{
    protected $table = 'asset_inspections';

    protected $fillable = [
        'workspace_id',
        'asset_inventory_id',
        'branch_id',
        'department_id',
        'inspector_id',
        'findings',
        'status',
        'cost_incurred',
        'inspected_at',
        'next_inspection_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'inspected_at' => 'datetime',
        'next_inspection_date' => 'date',
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(AssetInventory::class, 'asset_inventory_id');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'inspector_id');
    }

    public function scopeForWorkspace($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }
}
