<?php

namespace Workdo\Churchly\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetInventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'asset_inventories';

    protected $fillable = [
        'workspace_id',
        'branch_id',
        'department_id',
        'asset_name',
        'asset_code',
        'asset_tag',
        'category',
        'asset_type',
        'serial_number',
        'location',
        'condition',
        'acquired_at',
        'warranty_expires_at',
        'quantity',
        'available_quantity',
        'status',
        'assigned_to',
        'notes',
        'image_path',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'acquired_at' => 'date',
        'warranty_expires_at' => 'date',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(ChurchBranch::class, 'branch_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(ChurchDepartment::class, 'department_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function movements(): HasMany
    {
        return $this->hasMany(AssetMovement::class, 'asset_inventory_id');
    }

    public function inspections(): HasMany
    {
        return $this->hasMany(AssetInspection::class, 'asset_inventory_id');
    }

    public function scopeForWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        return $query->where('workspace_id', $workspaceId);
    }
}
