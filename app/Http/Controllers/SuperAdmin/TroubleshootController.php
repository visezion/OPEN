<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TroubleshootController extends Controller
{
    public function index()
    {
        $publicStorage = public_path('storage');
        $storagePublic = storage_path('app/public');

        $linkExists = is_link($publicStorage) || is_dir($publicStorage);
        $targetExists = is_dir($storagePublic);

        // Basic diagnostics
        $envExists = file_exists(base_path('.env'));
        $appKey = (string) config('app.key');
        $appKeySet = !empty($appKey);
        $writableStorage = is_writable(storage_path());
        $writableBootstrap = is_writable(base_path('bootstrap/cache'));
        $cacheDriver = config('cache.default');
        $queueConnection = config('queue.default');
        $sessionDriver = config('session.driver');

        // DB connectivity test
        $dbOk = true; $dbError = null;
        try {
            DB::select('select 1');
        } catch (\Throwable $e) {
            $dbOk = false; $dbError = $e->getMessage();
        }

        // Cache write test
        $cacheOk = true;
        try {
            Cache::put('__ts_check__', 'ok', 30);
            $cacheOk = Cache::get('__ts_check__') === 'ok';
        } catch (\Throwable $e) {
            $cacheOk = false;
        }

        // Tail last 100 lines of laravel.log (if exists)
        $logFile = storage_path('logs/laravel.log');
        $logTail = '';
        if (file_exists($logFile)) {
            try {
                $lines = @file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
                $logTail = implode("\n", array_slice($lines, max(count($lines) - 100, 0)));
            } catch (\Throwable $e) {
                $logTail = '';
            }
        }

        return view('superadmin.troubleshoot.index', compact(
            'linkExists', 'targetExists', 'publicStorage', 'storagePublic',
            'envExists', 'appKeySet', 'writableStorage', 'writableBootstrap',
            'cacheDriver', 'queueConnection', 'sessionDriver', 'dbOk', 'dbError',
            'cacheOk', 'logTail'
        ));
    }

    public function storageLink(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('setting manage')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        try {
            // Attempt to recreate the symbolic link
            Artisan::call('storage:link');
            return redirect()->back()->with('success', __('Public storage link created successfully.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', __('Failed to create storage link: ') . $e->getMessage());
        }
    }

    protected function runCommands(array $commands)
    {
        foreach ($commands as $cmd) {
            try {
                Artisan::call($cmd);
            } catch (\Throwable $e) {
                return [false, $cmd . ': ' . $e->getMessage()];
            }
        }
        return [true, null];
    }

    public function clearCaches(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('setting manage')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        [$ok, $err] = $this->runCommands([
            'cache:clear',
            'config:clear',
            'route:clear',
            'view:clear',
            'optimize:clear',
        ]);

        if (!$ok) {
            return redirect()->back()->with('error', __('Failed to clear caches: ') . $err);
        }
        return redirect()->back()->with('success', __('All caches cleared successfully.'));
    }

    public function buildCaches(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('setting manage')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        [$ok, $err] = $this->runCommands([
            'config:cache',
            'route:cache',
            'view:cache',
        ]);

        if (!$ok) {
            return redirect()->back()->with('error', __('Failed to rebuild caches: ') . $err);
        }
        return redirect()->back()->with('success', __('Configuration, routes and views cached successfully.'));
    }

    public function fixPermissions(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('setting manage')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

        try {
            // Ensure storage/app/public exists
            if (!Storage::disk('public')->exists('/')) {
                Storage::disk('public')->makeDirectory('/');
            }
            // Ensure base storage and bootstrap/cache are writable (best effort)
            @chmod(storage_path(), 0775);
            @chmod(base_path('bootstrap/cache'), 0775);
            return redirect()->back()->with('success', __('Verified directories and attempted to set write permissions.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', __('Permission fix failed: ') . $e->getMessage());
        }
    }

    public function clearLog(Request $request)
    {
        if (!Auth::user() || !Auth::user()->isAbleTo('setting manage')) {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        $logFile = storage_path('logs/laravel.log');
        try {
            if (file_exists($logFile)) {
                file_put_contents($logFile, '');
            }
            return redirect()->back()->with('success', __('Application log cleared.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', __('Failed to clear log: ') . $e->getMessage());
        }
    }
}
