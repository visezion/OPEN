<?php

namespace Workdo\Churchly\Console;

use Illuminate\Console\Command;
use Workdo\Churchly\Database\Seeders\PermissionTableSeeder;

class ChurchlyActivate extends Command
{
    protected $signature = 'churchly:activate';
    protected $description = '🚀 Activate the Churchly module: run migrations and seed permissions.';

    public function handle()
    {
        $this->info('⛪ Activating Churchly module...');

        // Run Churchly-specific migrations
        $this->info('📦 Running Churchly migrations...');
        $this->call('migrate', [
            '--path' => 'packages/workdo/Churchly/src/Database/Migrations',
            '--force' => true,
        ]);

        $this->info('✅ Migrations completed.');

        // Run PermissionTableSeeder directly
        $this->info('🔑 Seeding Churchly permissions...');
        $seeder = new PermissionTableSeeder();
        $seeder->run();
        $this->info('✅ Churchly permissions seeded successfully.');

        // Clear cache
        $this->info('🧹 Clearing cache...');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');

        $this->info('🎉 Churchly module activated and ready for use!');
    }
}
