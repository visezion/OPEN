<?php

namespace Workdo\Churchly\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Carbon;
use Workdo\Churchly\Entities\ChurchMember;

use Illuminate\Support\Facades\DB;
use Workdo\Taskly\Entities\ClientProject;
use Workdo\Taskly\Entities\Stage;
use Workdo\Taskly\Entities\Task;
use Workdo\Taskly\Entities\UserProject;
use App\Models\Notification;
use App\Models\User;



class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->isAbleTo('churchly dashboard manage')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        // ✅ Fetch and cache the Verse of the Day
        $verseOfDay = Cache::remember('verse_of_day', now()->addHours(12), function () {
            try {
                $response = Http::timeout(10)->get('https://beta.ourmanna.com/api/v1/get/?format=json');

                if ($response->failed()) {
                    return [
                        'text' => 'Unable to fetch today’s verse. Please try again later.',
                        'reference' => null,
                        'version' => null,
                    ];
                }

                $data = $response->json();
                $verse = $data['verse']['details'] ?? [];

                return [
                    'text' => $verse['text'] ?? 'Verse not available',
                    'reference' => $verse['reference'] ?? 'Unknown Reference',
                    'version' => $verse['version'] ?? 'KJV',
                ];
            } catch (\Exception $e) {
                return [
                    'text' => 'Error fetching Verse of the Day.',
                    'reference' => null,
                    'version' => null,
                ];
            }
        });
 $workspaceId = getActiveWorkSpace();

        // ✅ Total Members
        $totalMembers = ChurchMember::where('workspace', $workspaceId)->count();

        // ✅ Weekly New Members (last 7 days)
        $weeklyNewMembers = ChurchMember::where('workspace', $workspaceId)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->count();

        // ✅ Workers (members who belong to any department)
        $workers = ChurchMember::where('workspace', $workspaceId)
            ->whereHas('departments')
            ->count();

        // ✅ Leaders (have departments + designation name != 'Member')
        $leaders = ChurchMember::where('workspace', $workspaceId)
            ->whereHas('departments')
            ->whereHas('designation', function ($q) {
                $q->where('name', '!=', 'Member');
            })
            ->count();

        $stats = [
            'members'      => $totalMembers,
            'weekly_new'   => $weeklyNewMembers,
            'workers'      => $workers,
            'leaders'      => $leaders,
        ];
        // ✅ Return view with verse
        return view('churchly::dashboard.index', compact('verseOfDay', 'stats'));
    }
}