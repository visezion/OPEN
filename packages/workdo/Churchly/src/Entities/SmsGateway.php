<?php 

// src/Entities/SmsGateway.php
namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsGateway extends Model
{
    protected $fillable = [
        'workspace_id', 'driver', 'name', 'api_key', 'api_secret', 'url', 'from', 'extra'
    ];

    protected $casts = [
        'extra' => 'array',
    ];
}
