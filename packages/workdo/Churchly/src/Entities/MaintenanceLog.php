<?php

namespace Workdo\Churchly\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'maintenance_logs';

    protected $fillable = [
        'workspace_id',
        'schedule_id',
        'branch_id',
        'department_id',
        'due_date',
        'started_at',
        'completed_at',
        'status',
        'performed_by',
        'reported_by',
        'notes',
        'cost_incurred',
        'attachments',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'due_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(MaintenanceSchedule::class, 'schedule_id');
    }

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function scopeForWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        return $query->where('workspace_id', $workspaceId);
    }
}
