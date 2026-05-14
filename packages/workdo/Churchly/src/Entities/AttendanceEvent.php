<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AttendanceEvent extends Model
{
    protected $table = 'attendance_events';

    protected $fillable = [
        'workspace_id',
        'branch_id',
        'department_id',
        'event_id',
        'occurrence_id',
        'mode',
        'checkin_start_at',
        'checkin_end_at',
        'enabled_methods',
        'online_platform',
        'meeting_link',
        'host_start_url',
        'zoom_join_url',
        'meeting_id',
        'meeting_passcode',
        'zoom_meeting_uuid',
        'zoom_created_at',
        'zoom_created_by',
        'auto_log_attendance',
        'qr_code',
        'face_ai_enabled',
        'created_by',
    ];

    protected $casts = [
        'enabled_methods' => 'array',
        'face_ai_enabled' => 'boolean',
        'auto_log_attendance' => 'boolean',
        'checkin_start_at' => 'datetime',
        'checkin_end_at' => 'datetime',
        'zoom_created_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function occurrence()
    {
        return $this->belongsTo(EventOccurrence::class, 'occurrence_id');
    }

    public function records()
    {
        return $this->hasMany(AttendanceRecord::class, 'attendance_event_id');
    }

    public function getResolvedStartAtAttribute(): ?Carbon
    {
        $value = $this->occurrence?->starts_at ?: $this->checkin_start_at ?: $this->event?->start_time;

        if (!$value) {
            return null;
        }

        return $value instanceof Carbon ? $value : Carbon::parse($value);
    }

    public function getResolvedEndAtAttribute(): ?Carbon
    {
        $value = $this->occurrence?->ends_at ?: $this->checkin_end_at ?: $this->event?->end_time;

        if (!$value) {
            return null;
        }

        return $value instanceof Carbon ? $value : Carbon::parse($value);
    }

    public function getResolvedDateAttribute(): ?string
    {
        return $this->resolved_start_at?->toDateString();
    }

    public function getOccurrenceLabelAttribute(): string
    {
        if ($this->resolved_start_at) {
            return $this->resolved_start_at->format('d M Y h:i A');
        }

        return __('No scheduled date');
    }
}
