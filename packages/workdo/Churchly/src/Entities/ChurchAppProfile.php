<?php

namespace Workdo\Churchly\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChurchAppProfile extends Model
{
    use HasFactory;

    protected $table = 'church_app_profiles';

    protected $fillable = [
        'workspace_id',
        'app_name',
        'slug',
        'short_description',
        'about_text',
        'bundle_id_android',
        'bundle_id_ios',
        'primary_color',
        'accent_color',
        'background_color',
        'text_color',
        'font_family',
        'theme_mode',
        'logo_path',
        'splash_path',
        'icon_path',
        'favicon_path',
        'website_url',
        'facebook_url',
        'youtube_url',
        'instagram_url',
        'giving_url',
        'version',
        'status',
        'is_published',
        'last_published_at',
        'created_by',
        'updated_by',
    ];

    /* ---------------------------------------------------
     |  Global Scopes
     |---------------------------------------------------- */

    public function scopeForWorkspace($query)
    {
        return $query->where('workspace_id', getActiveWorkSpace());
    }

    /* ---------------------------------------------------
     |  Relationships
     |---------------------------------------------------- */

    public function features()
    {
        return $this->hasMany(ChurchAppFeature::class, 'workspace_id', 'workspace_id');
    }

    public function menuItems()
    {
        return $this->hasMany(ChurchAppMenuItem::class, 'workspace_id', 'workspace_id')
                    ->orderBy('sort_order');
    }

    public function publishSettings()
    {
        return $this->hasOne(ChurchAppPublishSetting::class, 'workspace_id', 'workspace_id');
    }

    public function texts()
    {
        return $this->hasMany(ChurchAppText::class, 'workspace_id', 'workspace_id');
    }

    public function media()
    {
        return $this->hasMany(ChurchAppMedia::class, 'workspace_id', 'workspace_id')
                    ->where('active', 1)
                    ->orderBy('order');
    }

    public function sections()
    {
        return $this->hasMany(ChurchAppSection::class, 'workspace_id', 'workspace_id')
                    ->where('is_visible', 1)
                    ->orderBy('order');
    }

    public function integrations()
    {
        return $this->hasMany(ChurchAppIntegration::class, 'workspace_id', 'workspace_id')
                    ->where('active', 1);
    }

    /* ---------------------------------------------------
     |  Accessors & Helpers
     |---------------------------------------------------- */

    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset($this->logo_path) : asset('images/default-logo.png');
    }

    public function getSplashUrlAttribute()
    {
        return $this->splash_path ? asset($this->splash_path) : null;
    }

    public function getIconUrlAttribute()
    {
        return $this->icon_path ? asset($this->icon_path) : asset('images/default-icon.png');
    }

    public function getFullColorPaletteAttribute()
    {
        return [
            'primary'   => $this->primary_color,
            'accent'    => $this->accent_color,
            'background'=> $this->background_color,
            'text'      => $this->text_color,
        ];
    }

    public function getIsLiveAttribute()
    {
        return $this->is_published && $this->status === 'ready';
    }
}
