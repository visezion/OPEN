<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Workdo\Churchly\Entities\{SitePage, SiteSection, SiteMenu, SiteTheme};

class CmsController extends Controller
{
    public function pages()
    {
        $pages = SitePage::where('workspace_id', getActiveWorkSpace())
            ->orderBy('sort_order')->get();
        return view('churchly::cms.pages', compact('pages'));
    }

    public function pageCreate()
    {
        return view('churchly::cms.page_edit', ['page' => new SitePage()]);
    }

    public function pageStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:191',
            'slug' => 'required|string|max:191',
            'is_home' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);
        $data['workspace_id'] = getActiveWorkSpace();
        $data['is_home'] = (bool)($data['is_home'] ?? false);
        $data['is_published'] = (bool)($data['is_published'] ?? true);
        $page = SitePage::create($data);
        if ($page->is_home) {
            SitePage::where('workspace_id', getActiveWorkSpace())
                ->where('id', '!=', $page->id)
                ->update(['is_home' => false]);
        }
        return redirect()->route('cms.pages.edit', $page->id)->with('success','Page created.');
    }

    public function pageEdit($id)
    {
        $page = SitePage::where('workspace_id', getActiveWorkSpace())->findOrFail($id);
        $sections = SiteSection::where('page_id', $page->id)->orderBy('sort_order')->get();
        return view('churchly::cms.page_edit', compact('page','sections'));
    }

    public function pageUpdate(Request $request, $id)
    {
        $page = SitePage::where('workspace_id', getActiveWorkSpace())->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|max:191',
            'slug' => 'required|string|max:191',
            'is_home' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_home'] = (bool)($data['is_home'] ?? false);
        $data['is_published'] = (bool)($data['is_published'] ?? true);
        $page->update($data);
        if ($page->is_home) {
            SitePage::where('workspace_id', getActiveWorkSpace())
                ->where('id', '!=', $page->id)
                ->update(['is_home' => false]);
        }
        return back()->with('success','Page updated.');
    }

    public function pageDestroy($id)
    {
        $page = SitePage::where('workspace_id', getActiveWorkSpace())->findOrFail($id);
        SiteSection::where('page_id',$page->id)->delete();
        $page->delete();
        return redirect()->route('cms.pages')->with('success','Page deleted.');
    }

    public function saveSections(Request $request, $id)
    {
        $page = SitePage::where('workspace_id', getActiveWorkSpace())->findOrFail($id);
        $rows = $request->input('sections', []);
        SiteSection::where('page_id',$page->id)->delete();
        foreach ($rows as $i => $row) {
            $type = $row['type'] ?? 'text';
            $title = $row['title'] ?? null;
            $content = $this->buildSectionContent($type, $row);
            SiteSection::create([
                'page_id' => $page->id,
                'type' => $type,
                'title' => $title,
                'content' => $content,
                'sort_order' => $i+1,
                'active' => isset($row['active']) ? (bool)$row['active'] : true,
            ]);
        }
        return back()->with('success','Sections saved.');
    }

    public function updatePagesOrder(\Illuminate\Http\Request $request)
    {
        $ids = $request->input('order', []);
        foreach ($ids as $i => $id) {
            SitePage::where('workspace_id', getActiveWorkSpace())->where('id',(int)$id)->update(['sort_order'=>$i+1]);
        }
        return back()->with('success','Order saved.');
    }

    public function theme()
    {
        $theme = SiteTheme::firstOrNew(['workspace_id'=>getActiveWorkSpace()]);
        return view('churchly::cms.theme', compact('theme'));
    }

    public function saveTheme(Request $request)
    {
        $data = $request->validate([
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'font_family' => 'nullable|string|max:191',
            'custom_css' => 'nullable|string',
            'logo_path' => 'nullable|file|mimes:png,jpg,jpeg,svg',
            'favicon_path' => 'nullable|file|mimes:png,ico,svg',
        ]);
        $theme = SiteTheme::firstOrNew(['workspace_id'=>getActiveWorkSpace()]);
        $theme->fill($data);
        foreach(['logo_path','favicon_path'] as $f){
            if ($request->hasFile($f)){
                $path = $request->file($f)->store('cms/'.getActiveWorkSpace(),'public');
                $theme->$f = $path;
            }
        }
        $theme->workspace_id = getActiveWorkSpace();
        $theme->save();
        return back()->with('success','Theme saved.');
    }

    public function menu()
    {
        $menu = SiteMenu::firstOrNew(['workspace_id'=>getActiveWorkSpace(),'location'=>'header']);
        return view('churchly::cms.menu', compact('menu'));
    }

    public function saveMenu(Request $request)
    {
        $menu = SiteMenu::firstOrNew(['workspace_id'=>getActiveWorkSpace(),'location'=>'header']);
        $menu->title = $request->input('title');
        $items = $request->input('items');
        if (is_string($items)) { $items = json_decode($items,true); }
        $menu->items = is_array($items) ? $items : [];
        $menu->workspace_id = getActiveWorkSpace();
        $menu->save();
        return back()->with('success','Menu saved.');
    }

    public function assets()
    {
        $dir = 'cms/'.getActiveWorkSpace().'/assets';
        $files = collect(\Storage::disk('public')->files($dir))->map(function($p){ return [ 'path'=>$p, 'url'=>asset(\Storage::url($p)) ]; });
        return view('churchly::cms.assets', ['files'=>$files]);
    }

    public function uploadAsset(\Illuminate\Http\Request $request)
    {
        $request->validate(['file'=>'required|file|mimes:png,jpg,jpeg,svg,webp,gif']);
        $path = $request->file('file')->store('cms/'.getActiveWorkSpace().'/assets','public');
        return back()->with('success','Uploaded')->with('uploaded', asset(\Storage::url($path)));
    }

    protected function coerceJson($value)
    {
        if (is_array($value)) return $value;
        if (is_string($value) && $value !== ''){
            try { $d = json_decode($value, true); return $d ?: $value; } catch (\Throwable $e) { return $value; }
        }
        return null;
    }

    protected function buildSectionContent(string $type, array $row): array
    {
        $cleanBool = fn($v) => (bool)$v;
        $trim = fn($s) => is_string($s) ? trim($s) : $s;
        switch ($type) {
            case 'hero':
                return [
                    'title_text' => $trim($row['title_text'] ?? null),
                    'subtitle' => $trim($row['subtitle'] ?? null),
                    'background_image' => $trim($row['background_image'] ?? null),
                    'button_text' => $trim($row['button_text'] ?? null),
                    'button_link' => $trim($row['button_link'] ?? null),
                ];
            case 'text':
                return [
                    'heading' => $trim($row['heading'] ?? null),
                    'body' => $trim($row['body'] ?? null),
                    'align' => in_array(($row['align'] ?? 'left'), ['left','center','right']) ? $row['align'] : 'left',
                ];
            case 'gallery':
                $images = [];
                if (!empty($row['images_text'])) {
                    foreach (preg_split('/\r?\n/', (string)$row['images_text']) as $line) {
                        $line = trim($line);
                        if ($line !== '') $images[] = $line;
                    }
                }
                return [ 'images' => $images ];
            case 'cta':
                return [
                    'title_text' => $trim($row['title_text'] ?? null),
                    'text' => $trim($row['text'] ?? null),
                    'link_text' => $trim($row['link_text'] ?? null),
                    'link_url' => $trim($row['link_url'] ?? null),
                ];
            case 'events':
                return [
                    'limit' => (int)($row['limit'] ?? 5),
                    'show_past' => $cleanBool($row['show_past'] ?? false),
                ];
            case 'sermon':
                return [
                    'video_url' => $trim($row['video_url'] ?? null),
                    'title_text' => $trim($row['title_text'] ?? null),
                ];
            default:
                return [];
        }
    }
}
