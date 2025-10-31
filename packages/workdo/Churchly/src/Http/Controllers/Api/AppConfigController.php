<?php

namespace Workdo\Churchly\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\WorkSpace;
use Workdo\Churchly\Services\AppConfigGenerator;

class AppConfigController extends Controller
{
    // GET /api/v1/churchly/church/{workspace}/config
    // {workspace} can be numeric id or short_code
    public function show(Request $request, $workspace)
    {
        $ws = WorkSpace::query()
            ->when(is_numeric($workspace), function ($q) use ($workspace) {
                $q->where('id', (int) $workspace);
            }, function ($q) use ($workspace) {
                $q->where('short_code', $workspace);
            })
            ->where('status', 'active')
            ->first();

        if (!$ws) {
            return response()->json([
                'status' => 'error',
                'message' => 'Church/workspace not found'
            ], 404);
        }

        $config = AppConfigGenerator::generate($ws->id) ?? [];

        // Compute a simple ETag to support client caching
        $json = json_encode($config, JSON_UNESCAPED_SLASHES);
        $etag = 'W/"'.md5($json).'"';

        // If client already has this version, return 304
        if ($request->headers->get('If-None-Match') === $etag) {
            return response('', 304)->header('ETag', $etag);
        }

        return response()->json([
            'status' => 'success',
            'data' => $config,
        ])->withHeaders([
            'ETag' => $etag,
            'Cache-Control' => 'no-cache',
        ]);
    }
}
