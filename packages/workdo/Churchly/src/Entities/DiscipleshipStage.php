<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscipleshipStage extends Model
{
    use HasFactory;

    protected $table = 'discipleship_stages';

    protected $fillable = [
        'workspace',
        'name',
        'description',
        'order',
        'created_by',
    ];

    public function requirements()
    {
        return $this->hasMany(DiscipleshipRequirement::class, 'stage_id');
    }

    public function progress()
    {
        return $this->hasMany(DiscipleshipMemberProgress::class, 'stage_id');
    }
}
