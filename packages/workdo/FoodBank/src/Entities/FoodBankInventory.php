<?php

namespace Workdo\FoodBank\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodBankInventory extends Model
{
    use SoftDeletes;

    protected $table = 'foodbank_inventory';

    protected $fillable = [
        'workspace_id',
        'item_name',
        'category',
        'description',
        'quantity',
        'unit',
        'received_at',
        'donor_id',
        'pickup_location',
        'delivery_details',
        'notify_channels',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'received_at' => 'date',
        'notify_channels' => 'array',
    ];

    public function donor(): BelongsTo
    {
        return $this->belongsTo(FoodBankDonor::class, 'donor_id');
    }
}
