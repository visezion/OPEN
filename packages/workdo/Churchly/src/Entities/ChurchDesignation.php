<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChurchDesignation extends Model
{
    use HasFactory;

    protected $table = 'church_designations';

    protected $fillable = [
        'name',
        'branch_id',
        'department_id',
        'workspace',
        'created_by',
    ];

    protected static function newFactory()
    {
        return \Workdo\Churchly\Database\factories\DesignationFactory::new();
    }

    /**
     * Get the branch associated with this designation.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(ChurchBranch::class, 'branch_id', 'id');
    }

    /**
     * Get the department associated with this designation.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(ChurchDepartment::class, 'department_id', 'id');
    }

    /**
     * WhatsApp groups linked to this designation.
     */
    public function whatsappGroups(): BelongsToMany
    {
        return $this->belongsToMany(
            ZenderWaGroup::class,
            'church_designation_wa_group',
            'designation_id',
            'group_id'
        );
    }
}
