<?php

namespace Workdo\FoodBank\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoodBankRequest extends Model
{
    use SoftDeletes;

    protected $table = 'foodbank_requests';

    protected $fillable = [
        'workspace_id',
        'requester_name',
        'phone',
        'email',
        'address',
        'needs_description',
        'quantity_needed',
        'pickup_location',
        'delivery_preference',
        'delivery_map',
        'delivery_lat',
        'delivery_lng',
        'notify_channels',
        'status',
        'occupation',
        'marital_status',
        'family_size',
        'children_count',
        'dietary_requirements',
        'approved_by',
        'approved_at',
        'distributed_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'distributed_at' => 'datetime',
        'family_size' => 'integer',
        'children_count' => 'integer',
        'notify_channels' => 'array',
        'delivery_lat' => 'float',
        'delivery_lng' => 'float',
    ];

    public function distributions(): HasMany
    {
        return $this->hasMany(FoodBankDistribution::class, 'request_id');
    }
}
