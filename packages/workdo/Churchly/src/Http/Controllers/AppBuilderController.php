<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Workdo\Churchly\Entities\{
    ChurchAppProfile,
    ChurchAppFeature,
    ChurchAppMenuItem,
    ChurchAppPublishSetting,
    ChurchAppChangeLog,
    ChurchAppLayout,
    ChurchAppWidget
};
use Workdo\Churchly\Services\AppConfigGenerator;

class AppBuilderController extends Controller
{
    public function index()
    {
        $workspaceId = getActiveWorkSpace();
        $profile  = ChurchAppProfile::forWorkspace()->first();
        $features = ChurchAppFeature::forWorkspace()->orderBy('sort_order')->get();
        $menus    = ChurchAppMenuItem::forWorkspace()->orderBy('sort_order')->get();
        $publish  = ChurchAppPublishSetting::forWorkspace()->first();

        // Prepare Home layout + widgets for inline editing tab (guard if tables missing)
        try {
            $homeLayout = ChurchAppLayout::firstOrCreate([
                'workspace_id' => $workspaceId,
                'screen_key'   => 'home',
            ], [
                'title' => 'Home',
                'is_active' => true,
            ]);
            $homeWidgets = ChurchAppWidget::where('layout_id', $homeLayout->id)
                ->orderBy('sort_order')
                ->get();
        } catch (\Throwable $e) {
            $homeLayout = null;
            $homeWidgets = collect();
        }

        return view('churchly::app-builder.index', compact('profile','features','menus','publish','homeLayout','homeWidgets'));
    }

    public function saveBranding(Request $request)
    {
        $validated = $request->validate([
            'app_name'=>'required|string|max:191',
            'primary_color'=>'nullable|string|max:20',
            'accent_color'=>'nullable|string|max:20',
            'theme_mode'=>'nullable|in:light,dark,system'
        ]);

        $profile = ChurchAppProfile::firstOrNew(['workspace_id'=>getActiveWorkSpace()]);
        $before = $profile->toArray();
        $profile->fill($validated);
        $profile->workspace_id = getActiveWorkSpace();

        foreach (['logo_path','splash_path','icon_path'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $path = $request->file($fileKey)->store('appbuilder/'.getActiveWorkSpace(), 'public');
                $profile->$fileKey = $path;
            }
        }

        $profile->save();

        ChurchAppChangeLog::create([
            'workspace_id'=>getActiveWorkSpace(),
            'changed_by'=>auth()->id(),
            'section'=>'branding',
            'before_json'=>$before,
            'after_json'=>$profile->toArray()
        ]);
        AppConfigGenerator::generate(getActiveWorkSpace());

        return back()->with('success','Branding updated successfully!');
    }

    public function saveFeatures(Request $request)
    {
        $features = $request->input('features', []);
        foreach($features as $feat) {
            ChurchAppFeature::updateOrCreate(
                ['workspace_id'=>getActiveWorkSpace(),'feature_key'=>$feat['feature_key']],
                ['enabled'=>$feat['enabled'] ?? true,'sort_order'=>$feat['sort_order'] ?? 0,'config'=>$feat['config'] ?? []]
            );
        }

        ChurchAppChangeLog::create([
            'workspace_id'=>getActiveWorkSpace(),
            'changed_by'=>auth()->id(),
            'section'=>'features',
            'after_json'=>$features
        ]);
        AppConfigGenerator::generate(getActiveWorkSpace());

        return back()->with('success','Features updated successfully!');
    }

    public function saveMenu(Request $request)
    {
        $items = $request->input('menu', []);
        ChurchAppMenuItem::where('workspace_id', getActiveWorkSpace())->delete();

        foreach($items as $i => $item) {
            ChurchAppMenuItem::create([
                'workspace_id'=>getActiveWorkSpace(),
                'title'=>$item['title'],
                'feature_key'=>$item['feature_key'] ?? null,
                'icon_name'=>$item['icon_name'] ?? null,
                'target_type'=>$item['target_type'] ?? 'feature',
                'target_value'=>$item['target_value'] ?? null,
                'sort_order'=>$i+1,
                'visible'=>$item['visible'] ?? true,
            ]);
        }

        ChurchAppChangeLog::create([
            'workspace_id'=>getActiveWorkSpace(),
            'changed_by'=>auth()->id(),
            'section'=>'menu',
            'after_json'=>$items
        ]);
        AppConfigGenerator::generate(getActiveWorkSpace());

        return back()->with('success','Menu saved successfully!');
    }

    public function publishSettings()
    {
        $publish = ChurchAppPublishSetting::forWorkspace()->first();
        return view('churchly::app-builder.publish', compact('publish'));
    }

    public function savePublishSettings(Request $request)
    {
        $validated = $request->validate([
            'release_channel'=>'required|in:multi_tenant,white_label',
            'current_version'=>'nullable|string|max:20'
        ]);

        $publish = ChurchAppPublishSetting::updateOrCreate(
            ['workspace_id'=>getActiveWorkSpace()],
            $validated
        );

        ChurchAppChangeLog::create([
            'workspace_id'=>getActiveWorkSpace(),
            'changed_by'=>auth()->id(),
            'section'=>'publish',
            'after_json'=>$publish->toArray()
        ]);
        AppConfigGenerator::generate(getActiveWorkSpace());

        return back()->with('success','Publish settings saved.');
    }

    public function saveLayout(Request $request)
    {
        $validated = $request->validate([
            'screen_key' => 'required|string',
            'title' => 'nullable|string',
            'widgets' => 'array',
            'widgets.*.type' => 'required|string',
            'widgets.*.title' => 'nullable|string',
            'widgets.*.settings' => 'nullable',
            'widgets.*.active' => 'nullable|boolean',
            'widgets.*.data_source' => 'nullable|string',
        ]);

        $workspaceId = getActiveWorkSpace();

        $layout = ChurchAppLayout::firstOrCreate(
            ['workspace_id' => $workspaceId, 'screen_key' => $validated['screen_key']],
            ['title' => $validated['title'] ?? ucfirst($validated['screen_key']), 'is_active' => true]
        );

        ChurchAppWidget::where('layout_id', $layout->id)->delete();
        $widgets = $request->input('widgets', []);
        foreach ($widgets as $i => $w) {
            $type = $w['type'] ?? 'custom_html';
            $settings = $this->buildWidgetSettings($type, $w);
            ChurchAppWidget::create([
                'layout_id' => $layout->id,
                'type' => $type,
                'title' => $w['title'] ?? null,
                'settings' => $settings,
                'sort_order' => $i + 1,
                'active' => isset($w['active']) ? (bool)$w['active'] : true,
                'data_source' => $w['data_source'] ?? null,
            ]);
        }

        ChurchAppChangeLog::create([
            'workspace_id'=> $workspaceId,
            'changed_by'=> auth()->id(),
            'section'=>'layout:'.$validated['screen_key'],
            'after_json'=> ['title'=>$layout->title,'widgets'=>$widgets]
        ]);

        AppConfigGenerator::generate($workspaceId);

        return back()->with('success','Layout saved successfully.');
    }

    protected function coerceJson($value)
    {
        if (is_array($value)) return $value;
        if (is_string($value) && $value !== '') {
            try { $decoded = json_decode($value, true); return $decoded ?: $value; } catch (\Throwable $e) { return $value; }
        }
        return null;
    }

    protected function buildWidgetSettings(string $type, array $w): array
    {
        $bool = fn($v) => (bool)$v;
        $trim = fn($s) => is_string($s) ? trim($s) : $s;
        switch ($type) {
            case 'banner_carousel':
                $images = [];
                if (!empty($w['images_text'])) {
                    foreach (preg_split('/\r?\n/', (string)$w['images_text']) as $line) {
                        $line = trim($line);
                        if ($line !== '') $images[] = $line;
                    }
                }
                return [
                    'images' => $images,
                    'autoplay' => $bool($w['autoplay'] ?? false),
                    'interval' => (int)($w['interval'] ?? 3000),
                ];
            case 'quick_links':
                $links = [];
                if (!empty($w['links_text'])) {
                    foreach (preg_split('/\r?\n/', (string)$w['links_text']) as $line) {
                        $line = trim($line);
                        if ($line === '') continue;
                        // format: Title|ti ti-icon|target
                        $parts = array_map('trim', explode('|', $line));
                        $links[] = [
                            'title' => $parts[0] ?? '',
                            'icon_name' => $parts[1] ?? 'ti ti-circle',
                            'target' => $parts[2] ?? '',
                        ];
                    }
                }
                return [ 'links' => $links ];
            case 'latest_sermons':
                return [
                    'limit' => (int)($w['limit'] ?? 5),
                    'source' => $trim($w['source'] ?? ''),
                ];
            case 'upcoming_events':
                return [
                    'limit' => (int)($w['limit'] ?? 5),
                    'show_past' => $bool($w['show_past'] ?? false),
                ];
            case 'custom_html':
            default:
                return [ 'html' => (string)($w['html'] ?? '') ];
        }
    }

    public function layoutEditor()
    {
        ChurchAppLayout::firstOrCreate([
            'workspace_id' => getActiveWorkSpace(),
            'screen_key' => 'home',
        ], [
            'title' => 'Home', 'is_active' => true
        ]);

        $layout = ChurchAppLayout::where('workspace_id', getActiveWorkSpace())
            ->where('screen_key','home')->first();
        $widgets = ChurchAppWidget::where('layout_id', $layout->id)
            ->orderBy('sort_order')->get();

        return view('churchly::app-builder.layout', compact('layout','widgets'));
    }
}
