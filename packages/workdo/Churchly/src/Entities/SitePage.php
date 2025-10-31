<?php
namespace Workdo\Churchly\Entities;
use Illuminate\Database\Eloquent\Model;
class SitePage extends Model
{
    protected $fillable = ['workspace_id','slug','title','meta','is_home','is_published','sort_order'];
    protected $casts = ['meta'=>'array','is_home'=>'boolean','is_published'=>'boolean'];
    public function sections(){ return $this->hasMany(SiteSection::class,'page_id')->where('active',1)->orderBy('sort_order'); }
}