<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class EventOccurrence extends Model
{
    protected $table = 'church_event_occurrences';

    protected $fillable = [
        'workspace_id',
        'event_id',
        'sequence',
        'starts_at',
        'ends_at',
        'is_cancelled',
        'created_by',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_cancelled' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function attendanceEvent()
    {
        return $this->hasOne(AttendanceEvent::class, 'occurrence_id');
    }

    public function getDateAttribute(): ?string
    {
        if (!$this->starts_at) {
            return null;
        }

        return ($this->starts_at instanceof Carbon ? $this->starts_at : Carbon::parse($this->starts_at))
            ->toDateString();
    }
}
