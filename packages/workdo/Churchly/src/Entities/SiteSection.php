<?php
namespace Workdo\Churchly\Entities;
use Illuminate\Database\Eloquent\Model;
class SiteSection extends Model
{
    protected $fillable = ['page_id','type','title','content','sort_order','active'];
    protected $casts = ['content'=>'array','active'=>'boolean'];
    public function page(){ return $this->belongsTo(SitePage::class,'page_id'); }
}