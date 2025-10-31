<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Workdo\Churchly\Entities\AttendanceEvent;
use Workdo\Churchly\Entities\ChurchEvent;

class ChurchVolunteerAssignment extends Model
{
    use HasFactory;

    protected $table = 'church_volunteer_assignments';

    protected $fillable = [
        'volunteer_id',
        'assignment_type',
        'assignment_id',
        'assignment_label',
        'role',
        'scheduled_for',
        'status',
        'notes',
        'workspace',
        'created_by',
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
    ];

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(ChurchVolunteer::class, 'volunteer_id');
    }

    /**
     * Resolve assignment context display name.
     */
    public function getContextLabelAttribute(): string
    {
        if (!empty($this->assignment_label)) {
            return $this->assignment_label;
        }

        if ($this->assignment_type === 'event' && $this->assignment_id) {
            $event = ChurchEvent::find($this->assignment_id);
            if ($event) {
                return $event->title ?? $event->name ?? ('Event #' . $this->assignment_id);
            }
        }

        if ($this->assignment_type === 'attendance_event' && $this->assignment_id) {
            $attendanceEvent = AttendanceEvent::find($this->assignment_id);
            if ($attendanceEvent && $attendanceEvent->event) {
                return $attendanceEvent->event->title ?? $attendanceEvent->event->name ?? ('Attendance #' . $this->assignment_id);
            }
        }

        return ucfirst(str_replace('_', ' ', $this->assignment_type));
    }
}
