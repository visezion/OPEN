<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberContribution extends Model
{
    use HasFactory;

    protected $table = 'church_member_contributions';

    protected $fillable = [
        'member_id',
        'amount',
        'currency',
        'received_at',
        'method',
        'reference',
        'meta',
        'workspace',
        'recorded_by',
    ];

    protected $casts = [
        'received_at' => 'date',
        'meta' => 'array',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(ChurchMember::class, 'member_id');
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'recorded_by');
    }

    public function scopeForWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        return $query->where(function ($inner) use ($workspaceId) {
            $inner->whereNull('workspace')->orWhere('workspace', $workspaceId);
        });
    }
}
