<?php

namespace Workdo\FoodBank\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodBankPublicToken extends Model
{
    use SoftDeletes;

    protected $table = 'foodbank_public_tokens';

    protected $fillable = [
        'workspace_id',
        'token',
        'created_by',
        'updated_by',
    ];
}
