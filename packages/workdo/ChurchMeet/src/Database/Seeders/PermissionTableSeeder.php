<?php

namespace Workdo\ChurchMeet\Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'churchly dashboard manage',
            'churchly settings manage',
            'churchly event create',
            'churchly event delete',
            'churchly event edit',
            'churchly event manage',
            'churchly event register',
            'churchly event show',
            'churchly attendance create',
            'churchly attendance delete',
            'churchly attendance edit',
            'churchly attendance import',
            'churchly attendance manage',
            'attendance mark',
            'attendance view',
            'attendance online',
            'attendance leaderboard',
            'church_program_timer manage',
            'church_program_timer show',
            'church_program_timer create',
            'church_program_timer edit',
            'church_program_timer delete',
        ];

        $companyRole = Role::where('name', 'company')->first();

        foreach ($permissions as $name) {
            $permission = Permission::firstOrCreate(
                [
                    'name' => $name,
                ],
                [
                    'module' => 'ChurchMeet',
                    'guard_name' => 'web',
                    'created_by' => 0,
                ]
            );

            $updates = [];
            if (empty($permission->module)) {
                $updates['module'] = 'ChurchMeet';
            }
            if (empty($permission->guard_name)) {
                $updates['guard_name'] = 'web';
            }
            if ($permission->created_by === null) {
                $updates['created_by'] = 0;
            }
            if (!empty($updates)) {
                $permission->fill($updates)->save();
            }

            if ($companyRole) {
                $companyRole->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }

        Artisan::call('cache:forget spatie.permission.cache');
    }
}
