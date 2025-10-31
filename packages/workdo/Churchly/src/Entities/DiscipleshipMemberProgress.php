<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class DiscipleshipMemberProgress extends Model
{
    use HasFactory;

    protected $table = 'discipleship_member_progress';

    protected $fillable = [
        'member_id',
        'stage_id',
        'requirement_id',
        'status',
        'evidence',
        'reviewed_by',
        'completed_at',
        'workspace',
        'points',
        'badge_awarded',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'badge_awarded' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Status Constants
    |--------------------------------------------------------------------------
    */
    const STATUS_PENDING   = 'pending';
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_APPROVED  = 'approved';
    const STATUS_COMPLETED = 'completed';

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function member()
    {
        return $this->belongsTo(ChurchMember::class, 'member_id');
    }

    public function stage()
    {
        return $this->belongsTo(DiscipleshipStage::class, 'stage_id');
    }

    public function requirement()
    {
        return $this->belongsTo(DiscipleshipRequirement::class, 'requirement_id');
    }
    
    public function reviewedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'reviewed_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function markCompleted(int $points = 0, bool $badge = false): void
    {
        $this->status = self::STATUS_COMPLETED;
        $this->completed_at = Carbon::now();
        $this->points = $points;
        $this->badge_awarded = $badge;
        $this->save();
    }

    public function awardPoints(int $points): void
    {
        $this->points += $points;
        $this->save();
    }

    public function markReviewed(int $reviewerId, string $newStatus = self::STATUS_APPROVED): void
    {
        $this->status = $newStatus;
        $this->reviewed_by = $reviewerId;
        $this->save();
    }
}
