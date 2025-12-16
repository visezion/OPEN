<?php

namespace Workdo\FoodBank\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodBankDistribution extends Model
{
    use SoftDeletes;

    protected $table = 'foodbank_distributions';

    protected $fillable = [
        'workspace_id',
        'request_id',
        'inventory_id',
        'quantity_distributed',
        'method',
        'delivery_address',
        'scheduled_at',
        'status',
        'handled_by',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(FoodBankRequest::class, 'request_id');
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(FoodBankInventory::class, 'inventory_id');
    }
}
