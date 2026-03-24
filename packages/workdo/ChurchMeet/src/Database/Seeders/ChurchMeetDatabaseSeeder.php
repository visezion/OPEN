<?php

namespace Workdo\ChurchMeet\Database\Seeders;

use Illuminate\Database\Seeder;

class ChurchMeetDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionTableSeeder::class,
        ]);
    }
}
