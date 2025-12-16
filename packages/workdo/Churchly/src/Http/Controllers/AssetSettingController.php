<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Workdo\Churchly\Entities\AssetNotificationSetting;

class AssetSettingController extends Controller
{
    private array $notificationMethods = ['email', 'sms', 'whatsapp'];

    public function index()
    {
        if ($response = $this->ensurePermission('asset inventory manage')) {
            return $response;
        }

        $settings = $this->getSetting();

        return view('churchly::assets.settings', [
            'settings' => $settings,
            'methods' => $this->notificationMethods,
        ]);
    }

    public function update(Request $request)
    {
        if ($response = $this->ensurePermission('asset inventory manage')) {
            return $response;
        }

        $data = $request->validate([
            'notification_methods' => ['array', Rule::in($this->notificationMethods)],
            'notification_time' => 'nullable|date_format:H:i',
            'low_stock_threshold' => 'required|integer|min:1|max:50',
            'inspection_reminder_days' => 'required|integer|min:1|max:30',
        ]);

        $payload = [
            'workspace_id' => getActiveWorkSpace(),
            'notification_methods' => $data['notification_methods'] ?? [],
            'notification_time' => $data['notification_time'] ?? null,
            'low_stock_threshold' => $data['low_stock_threshold'],
            'inspection_reminder_days' => $data['inspection_reminder_days'],
            'updated_by' => creatorId(),
        ];

        $settings = AssetNotificationSetting::forWorkspace()->first();

        if ($settings) {
            $settings->update($payload);
        } else {
            $payload['created_by'] = creatorId();
            AssetNotificationSetting::create($payload);
        }

        return Redirect::route('assets.settings.index')->with('success', __('Asset notification settings saved.'));
    }

    private function getSetting(): AssetNotificationSetting
    {
        return $this->ensureDefault(AssetNotificationSetting::forWorkspace()->first());
    }

    private function ensureDefault(?AssetNotificationSetting $setting): AssetNotificationSetting
    {
        if ($setting) {
            return $setting;
        }

        return AssetNotificationSetting::create([
            'workspace_id' => getActiveWorkSpace(),
            'notification_methods' => ['email'],
            'low_stock_threshold' => 5,
            'inspection_reminder_days' => 7,
            'created_by' => creatorId(),
            'updated_by' => creatorId(),
        ]);
    }

    private function userCanSkipPermissions(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return $user->hasRole('company') || $user->type === 'company';
    }

    private function ensurePermission(string $permission)
    {
        if ($this->userCanSkipPermissions() || Auth::user()->can($permission)) {
            return null;
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
