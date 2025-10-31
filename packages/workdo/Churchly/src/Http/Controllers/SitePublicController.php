<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Workdo\Churchly\Entities\{SitePage, SiteMenu, SiteTheme};

class SitePublicController extends Controller
{
    protected function resolveWorkspaceId($workspace)
    {
        if (is_numeric($workspace)) return (int)$workspace;
        if (class_exists('App\\Models\\WorkSpace')) {
            return optional(\App\Models\WorkSpace::where('short_code',$workspace)->first())->id ?? 0;
        }
        return 0;
    }

    public function home($workspace)
    {
        $wsId = $this->resolveWorkspaceId($workspace);
        $theme = SiteTheme::where('workspace_id',$wsId)->first();
        $menu = SiteMenu::where('workspace_id',$wsId)->where('location','header')->first();
        $page = SitePage::where('workspace_id',$wsId)->where('is_home',true)->with('sections')->first();
        return view('churchly::site.home', compact('theme','menu','page','workspace'));
    }

    public function page($workspace, $slug)
    {
        $wsId = $this->resolveWorkspaceId($workspace);
        $theme = SiteTheme::where('workspace_id',$wsId)->first();
        $menu = SiteMenu::where('workspace_id',$wsId)->where('location','header')->first();
        $page = SitePage::where('workspace_id',$wsId)->where('slug',$slug)->with('sections')->firstOrFail();
        return view('churchly::site.page', compact('theme','menu','page','workspace'));
    }
}