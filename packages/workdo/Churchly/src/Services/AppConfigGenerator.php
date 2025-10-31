<?php

namespace Workdo\Churchly\Services;

use Workdo\Churchly\Entities\{
    ChurchAppProfile,
    ChurchAppFeature,
    ChurchAppMenuItem,
    ChurchAppPublishSetting,
    ChurchAppLayout,
    ChurchAppWidget
};
use Illuminate\Support\Facades\Storage;

class AppConfigGenerator
{
    public static function generate(int $workspaceId)
    {
        $profile = ChurchAppProfile::where('workspace_id', $workspaceId)->first();
        if(!$profile) return null;

        $features = ChurchAppFeature::where('workspace_id', $workspaceId)
            ->where('enabled', true)
            ->orderBy('sort_order')
            ->get()
            ->pluck('feature_key');

        $menus = ChurchAppMenuItem::where('workspace_id', $workspaceId)
            ->where('visible', true)
            ->orderBy('sort_order')
            ->get(['title','feature_key','icon_name','target_type','target_value']);

        $publish = ChurchAppPublishSetting::where('workspace_id', $workspaceId)->first();

        $config = [
            'workspace_id' => $workspaceId,
            'app_name' => $profile->app_name ?? 'Church App',
            'primary_color' => $profile->primary_color ?? '#4A6CF7',
            'accent_color' => $profile->accent_color ?? '#F9B200',
            'theme_mode' => $profile->theme_mode ?? 'system',
            'logo_url' => $profile->logo_path ? asset(Storage::url($profile->logo_path)) : null,
            'splash_url' => $profile->splash_path ? asset(Storage::url($profile->splash_path)) : null,
            'icon_url' => $profile->icon_path ? asset(Storage::url($profile->icon_path)) : null,
            'features' => $features,
            'menu' => $menus,
            'publish' => [
                'release_channel' => $publish->release_channel ?? 'multi_tenant',
                'current_version' => $publish->current_version ?? null
            ],
        ];

        // Optional compact home layout embedding for simpler clients
        try {
            $homeLayout = ChurchAppLayout::where('workspace_id', $workspaceId)
                ->where('screen_key','home')
                ->where('is_active', true)
                ->first();
            if ($homeLayout) {
                $widgets = ChurchAppWidget::where('layout_id', $homeLayout->id)
                    ->where('active', true)
                    ->orderBy('sort_order')
                    ->get(['type','title','settings','sort_order','data_source']);
                $config['home'] = [
                    'screen_key' => 'home',
                    'title' => $homeLayout->title,
                    'widgets' => $widgets,
                ];
            }
        } catch (\Throwable $e) {
            // ignore to avoid breaking config
        }

        // Save JSON file for Flutter to read
        $path = "appbuilder/configs/{$workspaceId}.json";
        Storage::disk('public')->put($path, json_encode($config, JSON_PRETTY_PRINT));

        return $config;
    }
}
