<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;

class ChurchAppTheme extends Model
{
    protected $fillable = [
        'primary_color','secondary_color','font_family','logo_url','theme_mode','workspace_id','created_by'
    ];
}
