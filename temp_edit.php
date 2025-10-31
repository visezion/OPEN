<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Workdo\Churchly\Entities\{
    ChurchAppProfile,
    ChurchAppFeature,
    ChurchAppMenuItem,
    ChurchAppPublishSetting,
    ChurchAppChangeLog,\r\n    ChurchAppLayout,\r\n    ChurchAppWidget\r\n};
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

        return view('churchly::app-builder.index', compact('profile','features','menus','publish'));
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

        // handle uploads
        foreach (['logo_path','splash_path','icon_path'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $path = $request->file($fileKey)->store("appbuilder/".getActiveWorkSpace(), 'public');
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
}


