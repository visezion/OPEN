<?php
namespace Workdo\Churchly\Entities;
use Illuminate\Database\Eloquent\Model;
class SiteTheme extends Model
{
    protected $fillable = ['workspace_id','primary_color','secondary_color','font_family','logo_path','favicon_path','custom_css'];
}