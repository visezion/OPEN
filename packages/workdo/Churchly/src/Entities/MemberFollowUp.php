<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberFollowUp extends Model
{
    use HasFactory;

    protected $table = 'church_member_followups';

    protected $fillable = [
        'member_id',
        'assigned_to',
        'created_by',
        'subject',
        'description',
        'status',
        'due_at',
        'completed_at',
        'meta',
        'workspace',
    ];

    protected $casts = [
        'due_at' => 'date',
        'completed_at' => 'datetime',
        'meta' => 'array',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(ChurchMember::class, 'member_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['open', 'in_progress']);
    }

    public function scopeForWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        return $query->where(function ($inner) use ($workspaceId) {
            $inner->whereNull('workspace')->orWhere('workspace', $workspaceId);
        });
    }
}
