<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ChurchMemberCustomValue extends Model
{
    protected $table = 'church_member_custom_values';

    protected $fillable = [
        'member_id',
        'field_id',
        'field_key',
        'field_value',
        'workspace',
        'created_by',
    ];

    // 🔗 Relationships
    public function member()
    {
        return $this->belongsTo(ChurchMember::class, 'member_id');
    }

    public function field()
    {
        return $this->belongsTo(ChurchMemberField::class, 'field_id');
    }
}
