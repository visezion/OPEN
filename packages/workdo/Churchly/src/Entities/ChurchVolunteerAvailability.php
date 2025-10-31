<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChurchVolunteerAvailability extends Model
{
    use HasFactory;

    protected $table = 'church_volunteer_availabilities';

    protected $fillable = [
        'volunteer_id',
        'day_of_week',
        'start_time',
        'end_time',
        'effective_from',
        'effective_until',
        'timezone',
        'notes',
        'workspace',
        'created_by',
    ];

    protected $casts = [
        'effective_from' => 'date',
        'effective_until' => 'date',
    ];

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(ChurchVolunteer::class, 'volunteer_id');
    }
}
