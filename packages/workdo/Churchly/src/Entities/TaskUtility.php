<?php

namespace Workdo\Churchly\Entities;

use App\Models\Permission;
use App\Models\Role;

class TaskUtility
{
    /**
     * Assign Churchly permissions to the specified role.
     *
     * @param int|null $role_id
     * @param string|null $rolename
     * @return void
     */
    public static function GivePermissionToRoles($role_id = null, $rolename = null)
    {
        $churchly_permissions = [
            // Announcement
            'churchly announcement create',
            'churchly announcement delete',
            'churchly announcement edit',
            'churchly announcement manage',
            'churchly announcement show',

            // Asset
            'churchly asset create',
            'churchly asset delete',
            'churchly asset edit',
            'churchly asset manage',
            'churchly asset show',

            // Attendance
            'churchly attendance create',
            'churchly attendance delete',
            'churchly attendance edit',
            'churchly attendance import',
            'churchly attendance manage',

            // Branch
            'churchly branch create',
            'churchly branch delete',
            'churchly branch edit',
            'churchly branch manage',

            // Child Ministry
            'churchly child ministry checkin',
            'churchly child ministry checkout',
            'churchly child ministry manage',
            'churchly child ministry progress',

            // Communication
            'churchly communication broadcast',
            'churchly communication email',
            'churchly communication sms',

            // Counseling
            'churchly counseling create',
            'churchly counseling delete',
            'churchly counseling edit',
            'churchly counseling manage',
            'churchly counseling show',

            // Dashboard
            'churchly dashboard manage',

            // Department
            'churchly department create',
            'churchly department delete',
            'churchly department edit',
            'churchly department manage',

            // Designation
            'churchly designation create',
            'churchly designation delete',
            'churchly designation edit',
            'churchly designation manage',

            // Document
            'churchly document create',
            'churchly document edit',
            'churchly document manage',

            // Document Type
            'churchly documenttype create',
            'churchly documenttype delete',
            'churchly documenttype edit',
            'churchly documenttype manage',

            // Donation
            'churchly donation create',
            'churchly donation delete',
            'churchly donation edit',
            'churchly donation manage',
            'churchly donation report',

            // Event
            'churchly event create',
            'churchly event delete',
            'churchly event edit',
            'churchly event manage',
            'churchly event register',
            'churchly event show',

            // Expense
            'churchly expense create',
            'churchly expense delete',
            'churchly expense edit',
            'churchly expense manage',
            'churchly expense report',

            // Facility Booking
            'churchly facility booking create',
            'churchly facility booking delete',
            'churchly facility booking edit',
            'churchly facility booking manage',
            'churchly facility booking show',

            // Follow-up
            'churchly follow up manage',

            // IP Restrict
            'churchly ip restrict create',
            'churchly ip restrict delete',
            'churchly ip restrict edit',
            'churchly ip restrict manage',

            // Member
            'churchly member create',
            'churchly member delete',
            'churchly member edit',
            'churchly member export',
            'churchly member import',
            'churchly member manage',
            'churchly member show',

            // Prayer Request
            'churchly prayer request create',
            'churchly prayer request delete',
            'churchly prayer request edit',
            'churchly prayer request manage',
            'churchly prayer request show',

            // Program Timer
            'churchly program timer manage',

            // Reports
            'churchly report attendance',
            'churchly report donations',
            'churchly report expenses',
            'churchly report membership',
            'churchly report volunteer',

            // Role Management
            'churchly role assign',
            'churchly role create',
            'churchly role delete',
            'churchly role edit',
            'churchly role manage',

            // Service
            'churchly service create',
            'churchly service delete',
            'churchly service edit',
            'churchly service manage',
            'churchly service show',

            // Settings
            'churchly settings manage',

            // Church Policy
            'churchly churchpolicy create',
            'churchly churchpolicy delete',
            'churchly churchpolicy edit',
            'churchly churchpolicy manage',
        ];

        if ($role_id === null) {
            // Assign to all 'hr' and 'staff' roles if needed globally
            $roles = Role::whereIn('name', ['hr', 'staff'])->get();
            foreach ($roles as $role) {
                self::assignPermissions($role, $churchly_permissions);
            }
        } else {
            $role = Role::find($role_id);
            if ($role) {
                self::assignPermissions($role, $churchly_permissions);
            }
        }
    }

    /**
     * Helper method to safely attach permissions to the role.
     *
     * @param Role $role
     * @param array $permissions
     * @return void
     */
    protected static function assignPermissions(Role $role, array $permissions)
    {
        foreach ($permissions as $permission_name) {
            $permission = Permission::where('name', $permission_name)->first();
            if ($permission && !$role->hasPermission($permission_name)) {
                $role->givePermission($permission);
            }
        }
    }
}
