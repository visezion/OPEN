<?php

namespace Workdo\FoodBank\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodBankDonor extends Model
{
    use SoftDeletes;

    protected $table = 'foodbank_donors';

    protected $fillable = [
        'workspace_id',
        'name',
        'phone',
        'email',
        'address',
        'notes',
        'preferred_pickup',
        'preferred_delivery',
        'created_by',
        'updated_by',
    ];
}
