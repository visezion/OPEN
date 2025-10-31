<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChurchVolunteerTraining extends Model
{
    use HasFactory;

    protected $table = 'church_volunteer_trainings';

    protected $fillable = [
        'volunteer_id',
        'title',
        'provider',
        'completed_on',
        'valid_until',
        'status',
        'notes',
        'workspace',
        'created_by',
    ];

    protected $casts = [
        'completed_on' => 'date',
        'valid_until' => 'date',
    ];

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(ChurchVolunteer::class, 'volunteer_id');
    }
}
