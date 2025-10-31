<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventProgram extends Model
{
    use HasFactory;

    protected $table = 'church_event_programs';

    protected $fillable = [
        'event_id',
        'order_no',
        'program_item',
        'duration',
        'leader_id',
        'note',
        'status', // ✅ Added
    ];

    // 🔗 Relationships
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function leader()
    {
        return $this->belongsTo(ChurchMember::class, 'leader_id');
    }

    // 🔹 Helper: readable status
    public function getStatusLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status ?? 'planned'));
    }
}
