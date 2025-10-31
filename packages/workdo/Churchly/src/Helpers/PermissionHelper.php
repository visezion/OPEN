<?php

namespace Workdo\Churchly\Helpers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    /**
     * Ensure a permission exists in the DB and is linked to the company role.
     */
    public static function ensureExists(string $name, string $module = 'Churchly', string $guard = 'web'): Permission
    {
        $permission = Permission::firstOrCreate(
            [
                'name'   => $name,
                'module' => $module,
            ],
            [
                'guard_name' => $guard,
                'created_by' => 0,
            ]
        );

        // Attach to the company role so admins have it by default
        if ($role = Role::where('name', 'company')->first()) {
            $role->permissions()->syncWithoutDetaching([$permission->id]);
        }

        return $permission;
    }

    /**
     * Enforce a permission at runtime: auto-create if missing, abort 403 if the current
     * user does not have it.
     */
    public static function enforce(string $name): void
    {
        // Create it if it does not exist and attach to company role
        self::ensureExists($name);

        // Check current user ability
        $user = Auth::user();
        if (!$user || !$user->isAbleTo($name)) {
            abort(403, __('Permission denied.'));
        }
    }
}

