<?php

namespace Workdo\ChurchMeet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Event extends Model
{
    protected $table = 'church_events';

    protected $fillable = [
        'workspace_id',
        'created_by',
        'title',
        'description',
        'reviewer_comments',
        'event_type',
        'status',              // workflow status (draft, review, approved, published)
        'start_time',
        'end_time',
        'recurrence',
        'lead_id',
        'assistant_id',
        'venue',
        // GPS-based attendance location
        'latitude',
        'longitude',
        'radius_meters',
        'attendance_methods',
        'attachments',
        'reviewed_by',
        'approved_by',
        'published_by',
        'reviewed_at',
        'approved_at',
        'published_at',
    ];

    /**
     * Scope: filter events for active workspace
     */
    public function scopeInWorkspace($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }

    /**
     * Relationships
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function lead()
    {
        return $this->belongsTo(ChurchMember::class, 'lead_id');
    }

    public function assistant()
    {
        return $this->belongsTo(ChurchMember::class, 'assistant_id');
    }

    public function attendanceEvents()
    {
        return $this->hasMany(AttendanceEvent::class, 'event_id');
    }

    public function programs()
    {
        return $this->hasMany(EventProgram::class, 'event_id')->orderBy('order_no');
    }

    /**
     * Workflow Helper Methods
     */
    public function markAsReviewed()
    {
        $this->update([
            'status' => 'review',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);
    }

    public function markAsApproved()
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
    }

    public function markAsPublished()
    {
        $this->update([
            'status' => 'published',
            'published_by' => Auth::id(),
            'published_at' => now(),
        ]);
    }


    public function reviewerComments()
    {
        return $this->hasMany(ChurchEventReviewerComment::class, 'event_id')
                    ->orderBy('commented_at', 'asc');
    }

    public function getPublicViewKeyAttribute(): string
    {
        return static::encodePublicViewKey($this->getKey());
    }

    public static function encodePublicViewKey($eventId): string
    {
        return static::makeShortPublicToken((int) $eventId, 'event');
    }

    public static function decodePublicViewKey(string $value): ?int
    {
        $normalized = trim($value);

        if ($normalized === '') {
            return null;
        }

        if (ctype_digit($normalized)) {
            return (int) $normalized;
        }

        $shortTokenId = static::decodeShortPublicToken($normalized, 'event');
        if ($shortTokenId) {
            return $shortTokenId;
        }

        $normalized = strtr($normalized, '-_', '+/');
        $padding = strlen($normalized) % 4;

        if ($padding > 0) {
            $normalized .= str_repeat('=', 4 - $padding);
        }

        try {
            $decrypted = Crypt::decryptString($normalized);
        } catch (\Throwable $exception) {
            return null;
        }

        return ctype_digit($decrypted) ? (int) $decrypted : null;
    }

    protected static function makeShortPublicToken(int $id, string $context): string
    {
        $encodedId = strtolower(base_convert((string) $id, 10, 36));
        $signature = substr(hash_hmac('sha256', $context . ':' . $encodedId, (string) config('app.key')), 0, 8);

        return $encodedId . '-' . $signature;
    }

    protected static function decodeShortPublicToken(string $value, string $context): ?int
    {
        if (!preg_match('/^([0-9a-z]+)-([0-9a-f]{8})$/i', $value, $matches)) {
            return null;
        }

        $encodedId = strtolower($matches[1]);
        $signature = strtolower($matches[2]);
        $expectedSignature = substr(hash_hmac('sha256', $context . ':' . $encodedId, (string) config('app.key')), 0, 8);

        if (!hash_equals($expectedSignature, $signature)) {
            return null;
        }

        $decodedId = base_convert($encodedId, 36, 10);

        return ctype_digit((string) $decodedId) ? (int) $decodedId : null;
    }


}

