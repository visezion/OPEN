<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChurchVolunteer extends Model
{
    use HasFactory;

    protected $table = 'church_volunteers';

    protected $fillable = [
        'church_member_id',
        'full_name',
        'preferred_name',
        'email',
        'phone',
        'status',
        'joined_at',
        'notes',
        'workspace',
        'created_by',
    ];

    protected $casts = [
        'joined_at' => 'date',
    ];

    /**
     * Linked church member profile (optional).
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(ChurchMember::class, 'church_member_id');
    }

    /**
     * Assigned departments.
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(
            ChurchDepartment::class,
            'church_volunteer_departments',
            'volunteer_id',
            'department_id'
        )->withPivot('is_primary')->withTimestamps();
    }

    /**
     * Skill tags with optional proficiency levels.
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(
            ChurchVolunteerSkill::class,
            'church_volunteer_skill_map',
            'volunteer_id',
            'skill_id'
        )->withPivot('proficiency')->withTimestamps();
    }

    /**
     * Training history records.
     */
    public function trainings(): HasMany
    {
        return $this->hasMany(ChurchVolunteerTraining::class, 'volunteer_id');
    }

    /**
     * Preferred availability slots.
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(ChurchVolunteerAvailability::class, 'volunteer_id');
    }

    /**
     * Event or service assignments.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(ChurchVolunteerAssignment::class, 'volunteer_id');
    }

    /**
     * Scope records to workspace.
     */
    public function scopeForWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        return $query->where('workspace', $workspaceId);
    }

    /**
     * Scope records created by user.
     */
    public function scopeCreatedBy($query, $creatorId = null)
    {
        $creatorId = $creatorId ?? creatorId();
        return $query->where('created_by', $creatorId);
    }

    /**
     * Derived display label.
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->preferred_name) {
            return $this->preferred_name;
        }

        if ($this->member && $this->member->name) {
            return $this->member->name;
        }

        return $this->full_name;
    }

    /**
     * Primary department helper.
     */
    public function getPrimaryDepartmentAttribute(): ?ChurchDepartment
    {
        return $this->departments->first(function ($department) {
            return (bool) data_get($department, 'pivot.is_primary');
        });
    }

    /**
     * Check if volunteer is active.
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }
}
