<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscipleshipApprover extends Model
{
    use HasFactory;

    protected $table = 'discipleship_approvers';

    protected $fillable = [
        'user_id',
        'scope',
        'reference_id',
        'workspace',
    ];

    /**
     * Approver is a system user (pastor/admin/mentor)
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Scope Reference: could be Branch, Department, or Stage
     * (dynamic relationship depending on scope)
     */
    public function reference()
    {
        return match ($this->scope) {
            'branch'     => $this->belongsTo(ChurchBranch::class, 'reference_id'),
            'department' => $this->belongsTo(ChurchDepartment::class, 'reference_id'),
            'stage'      => $this->belongsTo(DiscipleshipStage::class, 'reference_id'),
            default      => null,
        };
    }
}
