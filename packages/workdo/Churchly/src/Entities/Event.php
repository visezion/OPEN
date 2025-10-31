<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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


}
