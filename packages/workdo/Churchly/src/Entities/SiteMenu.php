<?php
namespace Workdo\Churchly\Entities;
use Illuminate\Database\Eloquent\Model;
class SiteMenu extends Model
{
    protected $fillable = ['workspace_id','location','title','items'];
    protected $casts = ['items'=>'array'];
}