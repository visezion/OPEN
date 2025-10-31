<?php   

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsGatewaySetting extends Model
{
    protected $fillable = ['workspace_id', 'driver', 'config', 'is_active'];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    public function workspace()
    {
        return $this->belongsTo(\App\Models\Workspace::class);
    }
}
