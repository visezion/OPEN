<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberNote extends Model
{
    use HasFactory;

    protected $table = 'church_member_notes';

    protected $fillable = [
        'member_id',
        'author_id',
        'title',
        'body',
        'visibility',
        'tags',
        'requires_attention',
        'workspace',
    ];

    protected $casts = [
        'tags' => 'array',
        'requires_attention' => 'boolean',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(ChurchMember::class, 'member_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }

    public function scopeForWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        return $query->where(function ($inner) use ($workspaceId) {
            $inner->whereNull('workspace')->orWhere('workspace', $workspaceId);
        });
    }
}
