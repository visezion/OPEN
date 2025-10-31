<?php   

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class DiscipleshipStageEvent extends Model
{
    protected $table = 'discipleship_stage_events';

    protected $fillable = [
        'stage_id',
        'event_id',
    ];

    public function stage()
    {
        return $this->belongsTo(DiscipleshipStage::class, 'stage_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
