<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Household extends Model
{
    use HasFactory;

    protected $table = 'church_households';

    protected $fillable = [
        'name',
        'slug',
        'primary_contact_id',
        'phone',
        'email',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'notes',
        'workspace',
        'created_by',
    ];

    protected $casts = [
        'workspace' => 'integer',
        'created_by' => 'integer',
    ];

    public function primaryContact(): BelongsTo
    {
        return $this->belongsTo(ChurchMember::class, 'primary_contact_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            ChurchMember::class,
            'church_household_members',
            'household_id',
            'member_id'
        )->withPivot(['relationship', 'is_primary', 'joined_at'])
         ->withTimestamps();
    }

    public function scopeForWorkspace($query, $workspaceId = null)
    {
        $workspaceId = $workspaceId ?? getActiveWorkSpace();
        return $query->where(function ($inner) use ($workspaceId) {
            $inner->whereNull('workspace')->orWhere('workspace', $workspaceId);
        });
    }
}
