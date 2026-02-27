<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name'        => 'Network Operations Department',
                'code'        => 'NOD',
                'description' => 'Manages IT infrastructure, network equipment, laptops, desktops, servers, and switches.',
            ],
            [
                'name'        => 'Business Operations Department',
                'code'        => 'BOD',
                'description' => 'Handles day-to-day business operations including uniforms and supplies.',
            ],
            [
                'name'        => 'Planning, Research and Program Development Department',
                'code'        => 'PRPD',
                'description' => 'Responsible for organizational planning, research, and program development.',
            ],
            [
                'name'        => 'HR and Administrative Department',
                'code'        => 'HRAD',
                'description' => 'Handles human resources, administration, and general office management.',
            ],
            [
                'name'        => 'Galley Operations Department',
                'code'        => 'GOD',
                'description' => 'Manages food preparation, kitchen equipment, and food supply inventories.',
            ],
            [
                'name'        => 'Dormitory Operations Department',
                'code'        => 'DOD',
                'description' => 'Oversees dormitory facilities, bedding, and occupant support.',
            ],
            [
                'name'        => 'Finance Department',
                'code'        => 'FIN',
                'description' => 'Handles financial management, accounting, and budget control.',
            ],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['code' => $dept['code']], $dept);
        }
    }
}
