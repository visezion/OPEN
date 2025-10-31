<?php

namespace Workdo\Churchly\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Workdo\Churchly\Entities\{ChurchAppLayout, ChurchAppWidget, ChurchAppTheme};
use Illuminate\Http\Request;

class ChurchAppBuilderController extends Controller
{
    // Get all active layouts
    public function layouts()
    {
        $layouts = ChurchAppLayout::where('workspace_id', getActiveWorkSpace())
                    ->where('is_active', true)
                    ->orderBy('id')->get();

        return response()->json(['status'=>'success','data'=>$layouts]);
    }

    // Get layout by screen_key
    public function layout($screen_key)
    {
        $layout = ChurchAppLayout::with('widgets')
                    ->where('workspace_id', getActiveWorkSpace())
                    ->where('screen_key', $screen_key)->first();

        if(!$layout) {
            return response()->json(['status'=>'error','message'=>'Layout not found'],404);
        }

        return response()->json(['status'=>'success','data'=>$layout]);
    }

    // Get app theme
    public function theme()
    {
        $theme = ChurchAppTheme::where('workspace_id', getActiveWorkSpace())->latest()->first();

        if(!$theme){
            $theme = ChurchAppTheme::create([
                'workspace_id' => getActiveWorkSpace(),
                'created_by' => creatorId(),
            ]);
        }

        return response()->json(['status'=>'success','data'=>$theme]);
    }

    // Update theme (Admin only)
    public function updateTheme(Request $request)
    {
        $data = $request->validate([
            'primary_color'=>'nullable|string',
            'secondary_color'=>'nullable|string',
            'font_family'=>'nullable|string',
            'logo_url'=>'nullable|url',
            'theme_mode'=>'nullable|in:light,dark'
        ]);

        $theme = ChurchAppTheme::updateOrCreate(
            ['workspace_id'=>getActiveWorkSpace()],
            array_merge($data, ['created_by'=>creatorId()])
        );

        return response()->json(['status'=>'success','data'=>$theme]);
    }
}
