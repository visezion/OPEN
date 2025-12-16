<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TrackUsageMiddleware
{
    public function handle($request, Closure $next)
    {
        $start = microtime(true);
        $response = $next($request);
        $end = microtime(true);
        $executionTime = $end - $start;

        try {
            DB::table('usage_logs')->insert([
                'user_id' => Auth::id(),
                'workspace_id' => function_exists('getActiveWorkSpace') ? getActiveWorkSpace() : null,
                'route' => optional($request->route())->getName(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->header('User-Agent'),
                'controller' => optional(optional($request->route())->getAction())['controller'] ?? null,
                'method' => $request->method(),
                'execution_time' => $executionTime,
                'ip' => $request->ip(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // swallow logging failures
        }

        return $response;
    }
}
