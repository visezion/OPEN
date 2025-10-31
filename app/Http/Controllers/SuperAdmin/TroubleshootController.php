<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class TroubleshootController extends Controller
{
    public function index()
    {
        $publicStorage = public_path('storage');
        $storagePublic = storage_path('app/public');

        $linkExists = is_link($publicStorage) || is_dir($publicStorage);
        $targetExists = is_dir($storagePublic);

        return view('superadmin.troubleshoot.index', compact('linkExists', 'targetExists', 'publicStorage', 'storagePublic'));
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
}

