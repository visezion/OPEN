<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ChurchAppLayout extends Model
{
    protected $table = 'church_app_layouts';

    protected $fillable = [
        'workspace_id',
        'screen_key',
        'title',
        'is_active',
        'meta',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'meta' => 'array',
    ];

    public function scopeForWorkspace($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }

    public function widgets()
    {
        return $this->hasMany(ChurchAppWidget::class, 'layout_id')
            ->where('active', 1)
            ->orderBy('sort_order');
    }
}
