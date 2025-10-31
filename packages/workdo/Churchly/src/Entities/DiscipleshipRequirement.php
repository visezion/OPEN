<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscipleshipRequirement extends Model
{
    use HasFactory;

    protected $table = 'discipleship_requirements';

    protected $fillable = [
        'stage_id',
        'type',
        'title',
        'description',
        'is_mandatory',
        'points',
        'auto_complete',
        'requires_approval',
        'workspace',
        'created_by',
    ];

    public function stage()
    {
        return $this->belongsTo(DiscipleshipStage::class, 'stage_id');
    }

    public function checklists()
    {
        return $this->hasMany(DiscipleshipChecklist::class, 'requirement_id');
    }

    public function progress()
    {
        return $this->hasMany(DiscipleshipMemberProgress::class, 'requirement_id');
    }
}
