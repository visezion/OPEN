<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChurchVolunteerSkill extends Model
{
    use HasFactory;

    protected $table = 'church_volunteer_skills';

    protected $fillable = [
        'name',
        'category',
        'description',
        'is_active',
        'workspace',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Volunteers tagged with this skill.
     */
    public function volunteers(): BelongsToMany
    {
        return $this->belongsToMany(
            ChurchVolunteer::class,
            'church_volunteer_skill_map',
            'skill_id',
            'volunteer_id'
        )->withPivot('proficiency')->withTimestamps();
    }

    public function scopeForWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        return $query->where(function ($inner) use ($workspaceId) {
            $inner->whereNull('workspace')->orWhere('workspace', $workspaceId);
        });
    }
}
