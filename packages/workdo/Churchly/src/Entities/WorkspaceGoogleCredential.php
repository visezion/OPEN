<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class WorkspaceGoogleCredential extends Model
{
    protected $table = 'workspace_google_credentials';
    protected $fillable = [
        'workspace_id','client_id','client_secret','redirect_uri','active'
    ];
    protected $casts = ['active'=>'boolean'];
}