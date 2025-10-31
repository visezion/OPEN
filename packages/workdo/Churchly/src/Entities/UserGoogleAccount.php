<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class UserGoogleAccount extends Model
{
    protected $table = 'user_google_accounts';
    protected $fillable = [
        'user_id','workspace_id','google_id','email','access_token','refresh_token','expires_at','scopes'
    ];
    protected $casts = ['expires_at'=>'datetime'];

    public function setAccessTokenAttribute($value)
    {
        $this->attributes['access_token'] = encrypt($value);
    }
    public function getAccessTokenAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }
    public function setRefreshTokenAttribute($value)
    {
        if ($value) $this->attributes['refresh_token'] = encrypt($value);
    }
    public function getRefreshTokenAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }
}