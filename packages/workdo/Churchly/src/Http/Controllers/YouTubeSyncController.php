<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Workdo\Churchly\Entities\{YouTubeSyncSetting, YouTubeVideo};

class YouTubeSyncController extends Controller
{
    public function index()
    {
        $setting = YouTubeSyncSetting::firstOrNew(['workspace_id'=>getActiveWorkSpace()]);
        $videos = YouTubeVideo::where('workspace_id', getActiveWorkSpace())
            ->orderByDesc('published_at')->limit(20)->get();
        return view('churchly::integrations.youtube', compact('setting','videos'));
    }

    public function save(Request $request)
    {
        $data = $request->validate([
            'channel_id' => 'nullable|string',
            'playlist_id' => 'nullable|string',
            'mode' => 'required|in:all,live',
            'interval_minutes' => 'required|integer|min:5|max:1440',
            'api_key' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);
        $setting = YouTubeSyncSetting::firstOrNew(['workspace_id'=>getActiveWorkSpace()]);
        $setting->fill($data);
        $setting->workspace_id = getActiveWorkSpace();
        $setting->active = (bool)($data['active'] ?? false);
        $setting->save();
        return back()->with('success','YouTube sync settings saved.');
    }
}

