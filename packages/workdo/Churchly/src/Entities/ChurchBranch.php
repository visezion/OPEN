<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChurchBranch extends Model
{
    use HasFactory;

    protected $table = 'church_branches';

    protected $fillable = [
        'name',
        'workspace',
        'created_by',
    ];

    protected static function newFactory()
    {
        return \Workdo\Churchly\Database\factories\BranchFactory::new();
    }

    /**
     * WhatsApp groups linked to this church branch
     */
    public function whatsappGroups(): BelongsToMany
    {
        return $this->belongsToMany(
            ZenderWaGroup::class,
            'church_branch_wa_group',
            'branch_id',
            'group_id'
        );
    }
}
