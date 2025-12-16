<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\WorkSpace;

class SystemAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        $today = Carbon::today();
        $week = Carbon::now()->startOfWeek();
        $month = Carbon::now()->startOfMonth();

        $todayRequests = $this->countRequestsSince($today);
        $weekRequests = $this->countRequestsSince($week);
        $monthRequests = $this->countRequestsSince($month);
        $uniqueUsers = DB::table('usage_logs')
            ->where('created_at', '>=', $month)
            ->whereNotNull('user_id')
            ->distinct()
            ->count('user_id');

        $topRoutes = $this->queryRouteUsage()->orderByDesc('hits')->limit(10)->get();
        $slowRoutes = $this->queryRouteUsage()->orderByDesc('avg_time')->limit(10)->get();

        $functionStats = $this->buildFunctionStats();
        $errorFunctions = DB::table('function_logs')
            ->select('name', DB::raw('SUM(case when status = \'error\' then 1 else 0 end) as errors'))
            ->groupBy('name')
            ->orderByDesc('errors')
            ->limit(10)
            ->get();

        $latestErrors = DB::table('error_logs')->orderByDesc('created_at')->limit(20)->get();

        $workspaceStats = DB::table('usage_logs')
            ->select('workspace_id', DB::raw('COUNT(*) as total_requests'))
            ->groupBy('workspace_id')
            ->orderByDesc('total_requests')
            ->limit(10)
            ->get();

        $activeUsers = DB::table('usage_logs')
            ->select('user_id', DB::raw('COUNT(*) as requests'))
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderByDesc('requests')
            ->limit(10)
            ->get();

        $browserStats = $this->gatherAgentStats('browser');
        $deviceStats = $this->gatherAgentStats('device');

        $workspaceNames = WorkSpace::whereIn('id', $workspaceStats->pluck('workspace_id')->filter())->pluck('name', 'id')->toArray();
        $userNames = User::whereIn('id', $activeUsers->pluck('user_id')->filter())->pluck('name', 'id')->toArray();

        return view('superadmin.system_analytics', [
            'todayRequests' => $todayRequests,
            'weekRequests' => $weekRequests,
            'monthRequests' => $monthRequests,
            'uniqueUsersThisMonth' => $uniqueUsers,
            'topRoutes' => $topRoutes,
            'leastRoutes' => collect(),
            'slowRoutes' => $slowRoutes,
            'functionStats' => $functionStats,
            'errorFunctions' => $errorFunctions,
            'latestErrors' => $latestErrors,
            'workspaceStats' => $workspaceStats,
            'activeUsers' => $activeUsers,
            'workspaceNames' => $workspaceNames,
            'userNames' => $userNames,
            'dailyUsage' => $this->buildDailyUsage(30),
            'weeklyUsage' => $this->buildWeeklyUsage(8),
            'monthlyUsage' => $this->buildMonthlyUsage(12),
            'browserStats' => $browserStats,
            'deviceStats' => $deviceStats,
        ]);
    }

    public function map()
    {
        $ipUsage = DB::table('usage_logs')
            ->select('ip', DB::raw('COUNT(*) as requests'))
            ->whereNotNull('ip')
            ->groupBy('ip')
            ->orderByDesc('requests')
            ->limit(120)
            ->get();

        $globePoints = $ipUsage->map(function ($row) {
            $geo = $this->resolveIpGeo($row->ip);
            if (! $geo || ! isset($geo['lat'], $geo['lon'])) {
                return null;
            }

            return [
                'ip' => $row->ip,
                'requests' => $row->requests,
                'lat' => $geo['lat'],
                'lng' => $geo['lon'],
                'country' => $geo['country'] ?? __('Unknown'),
                'city' => $geo['city'] ?? null,
                'region' => $geo['region'] ?? null,
                'color' => $this->pickColor($row->requests),
            ];
        })->filter()->values();

        if ($globePoints->count() < 4) {
            $fallbackIps = DB::table('usage_logs')
                ->select('ip', DB::raw('COUNT(*) as requests'))
                ->whereNotNull('ip')
                ->groupBy('ip')
                ->orderByDesc('requests')
                ->limit(20)
                ->pluck('ip');

            foreach ($fallbackIps as $ip) {
                if ($globePoints->contains('ip', $ip)) {
                    continue;
                }

                $geo = $this->resolveIpGeo($ip);
                if ($geo && isset($geo['lat'], $geo['lon'])) {
                    $globePoints->push([
                        'ip' => $ip,
                        'requests' => 1,
                        'lat' => $geo['lat'],
                        'lng' => $geo['lon'],
                        'country' => $geo['country'] ?? __('Unknown'),
                        'city' => $geo['city'] ?? null,
                        'region' => $geo['region'] ?? null,
                        'color' => $this->pickColor(1),
                    ]);
                }

                if ($globePoints->count() >= 4) {
                    break;
                }
            }
        }

        $countrySummary = $globePoints
            ->groupBy('country')
            ->map(function ($items, $country) {
                return [
                    'country' => $country,
                    'requests' => $items->sum('requests'),
                    'lat' => $items->first()['lat'],
                    'lon' => $items->first()['lng'],
                ];
            })
            ->sortByDesc('requests')
            ->values()
            ->take(10);

        return view('superadmin.user_location_map', [
            'globePoints' => $globePoints,
            'countrySummary' => $countrySummary,
        ]);
    }

    private function resolveIpGeo(string $ip): ?array
    {
        return Cache::remember("geo_ip_location_{$ip}", now()->addDays(7), function () use ($ip) {
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=status,message,country,city,regionName,lat,lon");
                if ($response->ok() && $response->json('status') === 'success') {
                    return [
                        'country' => $response->json('country'),
                        'region' => $response->json('regionName'),
                        'city' => $response->json('city'),
                        'lat' => $response->json('lat'),
                        'lon' => $response->json('lon'),
                    ];
                }
            } catch (\Throwable $e) {
            }
            return null;
        });
    }

    private function countRequestsSince(Carbon $time): int
    {
        return DB::table('usage_logs')->where('created_at', '>=', $time)->count();
    }

    private function queryRouteUsage()
    {
        return DB::table('usage_logs')
            ->select('route', DB::raw('MIN(url) as sample_url'), DB::raw('COUNT(*) as hits'), DB::raw('AVG(execution_time) as avg_time'))
            ->groupBy('route');
    }

    private function buildFunctionStats()
    {
        return DB::table('function_logs')
            ->select('name', DB::raw('COUNT(*) as calls'), DB::raw('AVG(execution_time) as avg_time'))
            ->groupBy('name')
            ->orderByDesc('calls')
            ->limit(10)
            ->get();
    }

    private function buildDailyUsage(int $days = 30): array
    {
        $start = Carbon::today()->subDays($days - 1);
        $records = DB::table('usage_logs')
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $start)
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $result = [];
        for ($i = $days -1; $i >=0; $i--) {
            $date = Carbon::today()->subDays($i)->toDateString();
            $result[$date] = $records[$date] ?? 0;
        }
        return $result;
    }

    private function buildWeeklyUsage(int $weeks = 8): array
    {
        $start = Carbon::now()->startOfWeek()->subWeeks($weeks -1);
        $records = DB::table('usage_logs')
            ->select(DB::raw("YEARWEEK(created_at, 1) as yearweek"), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $start)
            ->groupBy('yearweek')
            ->pluck('total', 'yearweek')
            ->toArray();

        $result = [];
        $current = $start->copy();
        for ($i = 0; $i < $weeks; $i++) {
            $year = $current->format('o');
            $week = $current->format('W');
            $label = $current->format('M d');
            $key = "{$year}{$week}";
            $result[$label] = $records[$key] ?? 0;
            $current->addWeek();
        }
        return $result;
    }

    private function buildMonthlyUsage(int $months = 12): array
    {
        $start = Carbon::now()->startOfMonth()->subMonths($months - 1);
        $records = DB::table('usage_logs')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $start)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $result = [];
        $current = $start->copy();
        for ($i = 0; $i < $months; $i++) {
            $key = $current->format('Y-m');
            $label = $current->format('M Y');
            $result[$label] = $records[$key] ?? 0;
            $current->addMonth();
        }
        return $result;
    }

    private function gatherAgentStats(string $type = 'browser'): array
    {
        $agents = DB::table('usage_logs')
            ->select('user_agent')
            ->whereNotNull('user_agent')
            ->orderByDesc('created_at')
            ->limit(2000)
            ->pluck('user_agent');

        $counts = [];
        foreach ($agents as $agent) {
            $label = $type === 'device' ? $this->detectDeviceType($agent) : $this->detectBrowser($agent);
            if (! $label) {
                continue;
            }
            $counts[$label] = ($counts[$label] ?? 0) + 1;
        }

        arsort($counts);
        return array_slice($counts, 0, 6, true);
    }

    private function detectBrowser(string $agent): ?string
    {
        $agent = strtolower($agent);
        if (Str::contains($agent, ['edg/', 'edge/'])) {
            return 'Edge';
        }
        if (Str::contains($agent, ['opr/', 'opera'])) {
            return 'Opera';
        }
        if (Str::contains($agent, 'firefox')) {
            return 'Firefox';
        }
        if (Str::contains($agent, 'safari') && ! Str::contains($agent, 'chrome')) {
            return 'Safari';
        }
        if (Str::contains($agent, ['chrome', 'crios'])) {
            return 'Chrome';
        }
        if (Str::contains($agent, ['msie', 'trident'])) {
            return 'Internet Explorer';
        }
        return 'Other';
    }

    private function detectDeviceType(string $agent): ?string
    {
        $agent = strtolower($agent);
        if (Str::contains($agent, ['mobile', 'iphone', 'android']) && ! Str::contains($agent, ['ipad', 'tablet'])) {
            return 'Mobile';
        }
        if (Str::contains($agent, ['ipad', 'tablet'])) {
            return 'Tablet';
        }
        if (Str::contains($agent, ['macintosh', 'windows', 'linux'])) {
            return 'Desktop';
        }
        return 'Other';
    }

    private function pickColor(int $requests): string
    {
        if ($requests >= 4) {
            return '#ff4f4f';
        }
        if ($requests >= 2) {
            return '#ffa726';
        }
        return '#42a5f5';
    }
}
