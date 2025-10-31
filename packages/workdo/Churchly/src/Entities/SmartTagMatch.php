<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmartTagMatch extends Model
{
    use HasFactory;

    protected $table = 'church_smart_tag_members';

    protected $fillable = [
        'smart_tag_id',
        'member_id',
        'matched_at',
    ];

    protected $casts = [
        'matched_at' => 'datetime',
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(SmartTag::class, 'smart_tag_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(ChurchMember::class, 'member_id');
    }
}
