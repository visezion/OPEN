<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ChurchAppWidget extends Model
{
    protected $table = 'church_app_widgets';

    protected $fillable = [
        'layout_id',
        'type',
        'title',
        'settings',
        'sort_order',
        'active',
        'data_source',
    ];

    protected $casts = [
        'settings' => 'array',
        'active' => 'boolean',
    ];

    public function layout()
    {
        return $this->belongsTo(ChurchAppLayout::class, 'layout_id');
    }
}
