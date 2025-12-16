<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Workdo\Churchly\Entities\AssetInventory;
use Workdo\Churchly\Entities\ChurchBranch;

class AssetMovement extends Model
{
    protected $table = 'asset_movements';

    protected $fillable = [
        'workspace_id',
        'asset_inventory_id',
        'branch_id',
        'department_id',
        'from_branch_id',
        'from_department_id',
        'to_branch_id',
        'to_department_id',
        'quantity',
        'reason',
        'notes',
        'moved_at',
        'recorded_by',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'moved_at' => 'datetime',
    ];


    public function asset(): BelongsTo
    {
        return $this->belongsTo(AssetInventory::class, 'asset_inventory_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(ChurchBranch::class, 'branch_id');
    }

    public function fromBranch(): BelongsTo
    {
        return $this->belongsTo(ChurchBranch::class, 'from_branch_id');
    }

    public function toBranch(): BelongsTo
    {
        return $this->belongsTo(ChurchBranch::class, 'to_branch_id');
    }

    public function scopeForWorkspace($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }
}
