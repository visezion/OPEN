<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChurchDepartment extends Model
{
    protected $fillable = [
        'branch_id',
        'name',
        'workspace',
        'created_by',
    ];

    /**
     * Get the branch this department belongs to.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(ChurchBranch::class, 'branch_id', 'id');
    }

    /**
     * Get all designations under this department.
     */
    public function departments()
    {
        return $this->belongsToMany(ChurchDepartment::class, 'church_member_department')
            ->withPivot('designation_id') // ✅ pivot column
            ->withTimestamps();
    }

    public function members()
    {
        return $this->belongsToMany(
            ChurchMember::class,
            'church_member_department',
            'department_id',
            'church_member_id'
        )->withPivot('designation_id')->withTimestamps();
    }



    /**
     * WhatsApp groups linked to this department.
     */
    public function whatsappGroups(): BelongsToMany
    {
        return $this->belongsToMany(
            ZenderWaGroup::class,
            'church_department_wa_group',
            'department_id',
            'wa_group_id'
        );
    }
}
