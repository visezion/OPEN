<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SmartTag extends Model
{
    use HasFactory;

    protected $table = 'church_smart_tags';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'definition',
        'is_active',
        'last_run_at',
        'workspace',
        'created_by',
    ];

    protected $casts = [
        'definition' => 'array',
        'is_active' => 'boolean',
        'last_run_at' => 'datetime',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            ChurchMember::class,
            'church_smart_tag_members',
            'smart_tag_id',
            'member_id'
        )->withPivot(['matched_at'])
         ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        return $query->where(function ($inner) use ($workspaceId) {
            $inner->whereNull('workspace')->orWhere('workspace', $workspaceId);
        });
    }
}
