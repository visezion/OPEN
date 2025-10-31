<?php 

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ZenderWaGroup extends Model
{
    protected $fillable = [
        'workspace_id', 'group_id', 'name',
    ];

    
    // 🏢 Branches assigned to this WA group (pivot table relationship)
    public function branches(): BelongsToMany
    {
        return $this->belongsToMany(
            ChurchBranch::class,
            'church_branch_wa_group',  // pivot table
            'wa_group_id',                // this model's key in pivot
            'branch_id'                // related model's key in pivot
        );
    }

    // 🧩 Departments assigned to this WA group
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(
            ChurchDepartment::class,
            'church_department_wa_group',
            'wa_group_id',
            'department_id'
        );
    }

    // 👤 Designations assigned to this WA group
    public function designations(): BelongsToMany
    {
        return $this->belongsToMany(
            ChurchDesignation::class,
            'church_designation_wa_group',
            'wa_group_id',
            'designation_id'
        );
    }

    // Optional: get the raw pivot rows if needed (advanced use)
    public function branchMappings(): HasMany
    {
        return $this->hasMany(ChurchBranchWaGroup::class, 'wa_group_id');
    }

    public function departmentMappings(): HasMany
    {
        return $this->hasMany(ChurchDepartmentWaGroup::class, 'wa_group_id');
    }

    public function designationMappings(): HasMany
    {
        return $this->hasMany(ChurchDesignationWaGroup::class, 'wa_group_id');
    }
}
