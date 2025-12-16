<?php

namespace Workdo\Churchly\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Workdo\Churchly\Entities\MaintenanceCategory;
use Workdo\Churchly\Entities\MaintenanceSetting;

class MaintenanceSettingController extends Controller
{
    private array $notificationMethods = ['email', 'sms', 'whatsapp'];

    public function index()
    {
        $settings = MaintenanceSetting::forWorkspace()->first() ?? $this->createDefaultSettings();
        $categories = MaintenanceCategory::forWorkspace()->orderBy('name')->get();

        return view('churchly::maintenance.settings', [
            'settings' => $settings,
            'categories' => $categories,
            'methods' => $this->notificationMethods,
        ]);
    }

    public function update(Request $request)
    {
        if ($response = $this->ensurePermission('maintenance schedule manage')) {
            return $response;
        }

        $relative = MaintenanceSetting::forWorkspace()->first();
        $data = $request->validate([
            'notification_methods' => ['array', Rule::in($this->notificationMethods)],
            'notification_time' => 'nullable|date_format:H:i',
            'reminder_before_days' => 'required|integer|min:0|max:30',
            'default_category' => 'nullable|string',
        ]);

        $payload = [
            'notification_methods' => $data['notification_methods'] ?? [],
            'notification_time' => $data['notification_time'] ?? null,
            'reminder_before_days' => $data['reminder_before_days'],
            'default_category' => $data['default_category'] ?? null,
            'workspace_id' => getActiveWorkSpace(),
            'updated_by' => creatorId(),
        ];

        if ($relative) {
            $relative->update($payload);
        } else {
            $payload['created_by'] = creatorId();
            MaintenanceSetting::create($payload);
        }

        return Redirect::route('maintenance.settings.index')->with('success', __('Maintenance settings updated.'));
    }

    public function storeCategory(Request $request)
    {
        if ($response = $this->ensurePermission('maintenance schedule manage')) {
            return $response;
        }

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:191',
                Rule::unique('maintenance_categories')->where('workspace_id', getActiveWorkSpace()),
            ],
        ]);

        MaintenanceCategory::create([
            'workspace_id' => getActiveWorkSpace(),
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'created_by' => creatorId(),
            'updated_by' => creatorId(),
        ]);

        return Redirect::route('maintenance.settings.index')->with('success', __('Category added.'));
    }

    public function destroyCategory(MaintenanceCategory $category)
    {
        if ($category->workspace_id !== getActiveWorkSpace()) {
            abort(404);
        }

        if ($response = $this->ensurePermission('maintenance schedule manage')) {
            return $response;
        }

        $category->delete();

        return Redirect::route('maintenance.settings.index')->with('success', __('Category removed.'));
    }

    private function createDefaultSettings(): MaintenanceSetting
    {
        return MaintenanceSetting::create([
            'workspace_id' => getActiveWorkSpace(),
            'notification_methods' => ['email'],
            'reminder_before_days' => 2,
            'created_by' => creatorId(),
            'updated_by' => creatorId(),
        ]);
    }

    private function userCanSkipPermissions(): bool
    {
        $user = Auth::user();

        return $user && ($user->hasRole('company') || $user->type === 'company');
    }

    private function ensurePermission(string $permission)
    {
        if ($this->userCanSkipPermissions() || Auth::user()->can($permission)) {
            return null;
        }

        return redirect()->back()->with('error', __('Permission denied.'));
    }
}
