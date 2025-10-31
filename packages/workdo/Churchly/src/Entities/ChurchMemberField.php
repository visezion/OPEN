<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChurchMemberField extends Model
{
    use HasFactory;

    protected $table = 'church_member_custom_fields';

     protected $fillable = [
        'member_id',
        'field_key',
        'field_label',
        'field_value',
        'field_type',
        'order',
        'workspace',
        'created_by',
    ];

    public $timestamps = true;

    // Relations
    public function member()
    {
        return $this->belongsTo(ChurchMember::class, 'member_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
