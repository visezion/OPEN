<?php

namespace Workdo\FoodBank\Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $permissions = [
            'foodbank donor manage',
            'foodbank donor create',
            'foodbank donor edit',
            'foodbank donor delete',
            'foodbank inventory manage',
            'foodbank inventory create',
            'foodbank inventory edit',
            'foodbank inventory delete',
            'foodbank request manage',
            'foodbank request create',
            'foodbank request edit',
            'foodbank request delete',
            'foodbank request approve',
            'foodbank distribution manage',
            'foodbank distribution create',
            'foodbank distribution edit',
            'foodbank distribution delete',
            'foodbank reports view',
        ];

        $module = 'FoodBank';

        $companyRole = Role::where('name', 'company')->first();

        foreach ($permissions as $name) {
            $permission = Permission::firstOrCreate(
                ['name' => $name, 'module' => $module],
                ['guard_name' => 'web', 'created_by' => 0]
            );

            if ($companyRole) {
                $companyRole->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }

        Artisan::call('cache:forget spatie.permission.cache');
    }
}
