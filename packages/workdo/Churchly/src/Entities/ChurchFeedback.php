<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Workdo\Churchly\Entities\ChurchBranch;
use Workdo\Churchly\Entities\ChurchDepartment;
class ChurchFeedback extends Model
{
    

    protected $table = 'church_feedback';

    protected $fillable = [
        'title',
        'message',
        'type',
        'category',
        'is_anonymous',
        'name',
        'email',
        'status',
        'admin_response',
        'reviewed_at',
        'attachment',
        'submitted_by',
        'reviewed_by',
        'workspace_id',
        'branch_id',
        'department_id',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Relationship: User who submitted the feedback
     */
    public function submitter()
    {
        return $this->belongsTo(\App\Models\User::class, 'submitted_by');
    }

    /**
     * Relationship: Admin who reviewed the feedback
     */
    public function reviewer()
    {
        return $this->belongsTo(\App\Models\User::class, 'reviewed_by');
    }

    /**
     * Relationship: Workspace the feedback belongs to
     */
    public function workspace()
    {
        return $this->belongsTo(\App\Models\Workspace::class, 'workspace_id');
    }

    /**
     * Relationship: Branch within the workspace
     */
    public function branch()
    {
        return $this->belongsTo(ChurchBranch::class, 'branch_id');
    }

    /**
     * Relationship: Department within the branch
     */
    public function department()
    {
        return $this->belongsTo(ChurchDepartment::class, 'department_id');
    }


    public function getFormattedStatusAttribute()
    {
        return ucfirst($this->status);
    }

    public function getFormattedSubmittedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d M Y, h:i A') : '-';
    }

}
