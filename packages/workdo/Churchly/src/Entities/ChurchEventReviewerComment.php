<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ChurchEventReviewerComment extends Model
{
    protected $table = 'church_event_reviewer_comments';

    protected $fillable = [
        'event_id',
        'user_id',
        'role',
        'comment',
        'commented_at',
    ];

    /**
     * Relationships
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Automatically attach user info when creating
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check() && empty($model->user_id)) {
                $model->user_id = Auth::id();
            }
            if (empty($model->commented_at)) {
                $model->commented_at = now();
            }
        });
    }

    /**
     * Format comment date for display
     */
    public function getFormattedDateAttribute()
    {
        return $this->commented_at
            ? $this->commented_at->diffForHumans()
            : 'N/A';
    }
}
