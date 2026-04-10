<?php

namespace Workdo\Churchly\Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        Artisan::call('cache:clear');

        $module = 'Churchly';

        $permissions = [

            // 📦 Assets
            'churchly asset create',
            'churchly asset delete',
            'churchly asset edit',
            'churchly asset manage',
            'churchly asset show',
            // Maintenance
            'maintenance schedule create',
            'maintenance schedule edit',
            'maintenance schedule delete',
            'maintenance schedule manage',
            'maintenance log manage',
            'maintenance log update',

            // Asset Inventory
            'asset inventory create',
            'asset inventory edit',
            'asset inventory delete',
            'asset inventory manage',
            'asset inventory view',
            'asset movement manage',
            'asset movement record',
            'asset inspection manage',
            'asset inspection create',
            'asset notification manage',

            // 🌿 Branches
            'church_branch create',
            'church_branch delete',
            'church_branch edit',
            'church_branch manage',

            // 📡 Communication
            'churchly communication broadcast',
            'churchly communication email',
            'churchly communication sms',

            // 📊 Dashboard
            'churchly dashboard manage',

            // 🏢 Departments
            'church_department create',
            'church_department delete',
            'church_department edit',
            'church_department manage',

            // 👔 Designations
            'church_designation create',
            'church_designation delete',
            'church_designation edit',
            'church_designation manage',

            // 👥 Members
            'church_member create',
            'church_member delete',
            'church_member edit',
            'church_member export',
            'church_member import',
            'church_member manage',
            'church_member show',

            // Volunteer Management
            // Volunteer Management (granular)
            'church_volunteer edit',
            'church_volunteer delete',

            // Volunteer Skills
            'church_volunteer_skill manage',
            'church_volunteer_skill create',
            'church_volunteer_skill edit',
            'church_volunteer_skill delete',

            // Households & Care (granular)
            'church_household create',
            'church_household edit',
            'church_household delete',

            'church_member_note create',
            'church_member_note edit',
            'church_member_note delete',

            'church_member_followup create',
            'church_member_followup edit',
            'church_member_followup delete',

            'church_member_communication create',
            'church_member_communication edit',
            'church_member_communication delete',

            // Smart Tags
            'church_smart_tag create',
            'church_smart_tag edit',
            'church_smart_tag delete',
            'church_smart_tag run',
            'church_volunteer manage',
            'church_volunteer create',

            // Household & care records
            'church_household manage',
            'church_member_note manage',
            'church_member_followup manage',
            'church_member_communication manage',
            'church_smart_tag manage',

            // ⏱ Program Timer
            'church_program_timer manage',
            'church_program_timer show',
            'church_program_timer create',
            'church_program_timer delete',
            'church_program_timer edit',

            // 🎭 Roles
            'church_role assign',
            'church_role create',
            'church_role delete',
            'church_role edit',
            'church_role manage',

            // ⚙️ Settings
            'church_settings manage',

            // 💬 WhatsApp integration
            'connect_whatsApp view',
            'connect_whatsApp create',
            'connect_whatsApp delete',
            'connect_whatsApp edit',

            // 📝 Feedback
            'feedback view own',
            'feedback view branch',
            'feedback view department',
            'feedback view all',
            'feedback delete',
            'feedback edit',
            'feedback review',

            'church_settings manage',

            //birthday template manage
            'birthday_templates manage',
            'birthday_templates create',
            'birthday_templates delete',
            'birthday_templates edit',

            //discipleship
            'discipleship manage',
            'discipleship create',
            'discipleship delete',
            'discipleship edit',
            
            //attendance 
           // 'attendance manage',     // create/update/delete events
            'attendance mark',       // mark/check-in members
            'attendance view',       // view attendance reports
            'attendance online',     // allow self online check-in
            'attendance leaderboard', // view leaderboards


            // 📱 App Builder Permissions
            'app_builder view',
            'app_builder edit branding',
            'app_builder edit features',
            'app_builder edit menu',
            'app_builder manage publish',
                    
        ];

        // Get company role
        $company_role = Role::where('name', 'company')->first();

        $permissions = array_values(array_unique(array_map('trim', $permissions)));

        foreach ($permissions as $value) {
            // "permissions.name" is globally unique, so resolve by name first.
            $permission = Permission::where('name', $value)->first();

            if (!$permission) {
                $permission = Permission::create([
                    'name'       => $value,
                    'module'     => $module,
                    'guard_name' => 'web',
                    'created_by' => 0,
                ]);
            } else {
                $updates = [];
                if (empty($permission->module)) {
                    $updates['module'] = $module;
                }
                if (empty($permission->guard_name)) {
                    $updates['guard_name'] = 'web';
                }
                if (is_null($permission->created_by)) {
                    $updates['created_by'] = 0;
                }
                if (!empty($updates)) {
                    $permission->update($updates);
                }
            }

            if ($company_role) {
                // Attach permission to role safely
                $company_role->permissions()->syncWithoutDetaching([$permission->id]);
            }
        }

        Artisan::call('cache:forget spatie.permission.cache');

        $this->command->info('✅ Churchly modular permissions seeded and linked to company role successfully.');
    }
}
