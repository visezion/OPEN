<?php

namespace Workdo\ChurchMeet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class AttendanceEvent extends Model
{
    protected $table = 'attendance_events';

    protected $fillable = [
        'workspace_id',
        'branch_id',
        'department_id',
        'event_id',
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

    public function records()
    {
        return $this->hasMany(AttendanceRecord::class, 'attendance_event_id');
    }

    public function getPublicJoinKeyAttribute(): string
    {
        return static::encodePublicJoinKey($this->getKey());
    }

    public static function encodePublicJoinKey($attendanceEventId): string
    {
        $encrypted = Crypt::encryptString((string) $attendanceEventId);

        return rtrim(strtr($encrypted, '+/', '-_'), '=');
    }

    public static function decodePublicJoinKey(string $value): ?int
    {
        $normalized = trim($value);

        if ($normalized === '') {
            return null;
        }

        if (ctype_digit($normalized)) {
            return (int) $normalized;
        }

        $decrypted = static::decryptPublicJoinKey($normalized);

        return is_string($decrypted) && ctype_digit($decrypted)
            ? (int) $decrypted
            : null;
    }

    protected static function decryptPublicJoinKey(string $value): ?string
    {
        $normalized = strtr($value, '-_', '+/');
        $padding = strlen($normalized) % 4;

        if ($padding > 0) {
            $normalized .= str_repeat('=', 4 - $padding);
        }

        try {
            return Crypt::decryptString($normalized);
        } catch (\Throwable $exception) {
            return null;
        }
    }
}

