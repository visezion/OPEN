<?php
namespace Workdo\Churchly\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Workdo\Churchly\Entities\{SitePage, SiteSection, SiteMenu, SiteTheme};

class SiteController extends Controller
{
    // GET /api/v1/churchly/site/{workspace}/config
    public function config($workspace)
    {
        $wsId = is_numeric($workspace) ? (int)$workspace : (int) ($this->resolveWorkspaceId($workspace));
        $theme = SiteTheme::where('workspace_id',$wsId)->first();
        $menu = SiteMenu::where('workspace_id',$wsId)->where('location','header')->first();
        $home = SitePage::where('workspace_id',$wsId)->where('is_home',true)->with('sections')->first();
        $data = [
            'workspace_id' => $wsId,
            'theme' => $theme,
            'menu' => $menu,
            'home' => $home,
        ];
        return response()->json(['status'=>'success','data'=>$data]);
    }

    // GET /api/v1/churchly/site/{workspace}/pages
    public function pages($workspace)
    {
        $wsId = is_numeric($workspace) ? (int)$workspace : (int) ($this->resolveWorkspaceId($workspace));
        $pages = SitePage::where('workspace_id',$wsId)->where('is_published',true)->orderBy('sort_order')->get(['slug','title','is_home']);
        return response()->json(['status'=>'success','data'=>$pages]);
    }

    // GET /api/v1/churchly/site/{workspace}/page/{slug}
    public function page($workspace, $slug)
    {
        $wsId = is_numeric($workspace) ? (int)$workspace : (int) ($this->resolveWorkspaceId($workspace));
        $page = SitePage::where('workspace_id',$wsId)->where('slug',$slug)->with('sections')->first();
        if(!$page) return response()->json(['status'=>'error','message'=>'Page not found'],404);
        return response()->json(['status'=>'success','data'=>$page]);
    }

    protected function resolveWorkspaceId($short)
    {
        if (class_exists('App\\Models\\WorkSpace')) {
            return optional(\App\Models\WorkSpace::where('short_code',$short)->first())->id ?? 0;
        }
        return 0;
    }
}