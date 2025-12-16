<?php

namespace Workdo\Churchly\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'maintenance_schedules';

    protected $fillable = [
        'workspace_id',
        'branch_id',
        'department_id',
        'asset_name',
        'asset_code',
        'location',
        'category',
        'priority',
        'frequency_type',
        'frequency_value',
        'start_date',
        'end_date',
        'next_due_date',
        'last_completed_at',
        'estimated_duration_minutes',
        'estimated_cost',
        'status',
        'assigned_to',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'next_due_date' => 'date',
        'last_completed_at' => 'datetime',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class, 'schedule_id');
    }

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

    public function scopeForWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        return $query->where('workspace_id', $workspaceId);
    }
}
