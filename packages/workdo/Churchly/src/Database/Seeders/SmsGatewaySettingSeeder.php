<?php
// File: packages/workdo/Churchly/src/Database/Seeders/SmsGatewaySettingSeeder.php

namespace Workdo\Churchly\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SmsGatewaySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sms_gateway_settings')->insert([
            'workspace_id' => 1,
            'driver'       => 'zender',
            'config'       => json_encode([
                'url'    => 'https://zender.vicezion.com',
                'token'  => 'sample-token',
                'sender' => 'CHURCHLY',
            ]),
            'is_active'   => true,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
}
