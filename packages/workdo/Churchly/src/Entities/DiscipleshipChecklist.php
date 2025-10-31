<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscipleshipChecklist extends Model
{
    use HasFactory;

    protected $table = 'discipleship_checklists';

    protected $fillable = [
        'requirement_id',
        'item',
        'is_completed',
        'workspace',
        'created_by',
    ];

    public function requirement()
    {
        return $this->belongsTo(DiscipleshipRequirement::class, 'requirement_id');
    }
}
