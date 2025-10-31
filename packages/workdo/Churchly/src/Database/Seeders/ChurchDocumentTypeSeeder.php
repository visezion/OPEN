<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Workdo\Churchly\Entities\ChurchDocumentType;

class ChurchDocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $documentTypes = [
            ['name' => 'Baptism Certificate', 'is_required' => true],
            ['name' => 'Membership Form', 'is_required' => false],
            ['name' => 'Marriage Certificate', 'is_required' => false],
        ];

        foreach ($documentTypes as $type) {
            ChurchDocumentType::create([
                'name' => $type['name'],
                'is_required' => $type['is_required'],
                'workspace' => 1,
                'created_by' => 1,
            ]);
        }
    }
}
