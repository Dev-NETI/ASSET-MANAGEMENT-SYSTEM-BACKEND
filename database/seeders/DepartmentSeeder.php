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
                'head_name'   => 'John Mendoza',
            ],
            [
                'name'        => 'Business Operations Department',
                'code'        => 'BOD',
                'description' => 'Handles day-to-day business operations including uniforms and supplies.',
                'head_name'   => 'Maria Santos',
            ],
            [
                'name'        => 'Planning, Research and Program Development Department',
                'code'        => 'PRPD',
                'description' => 'Responsible for organizational planning, research, and program development.',
                'head_name'   => 'Ana Reyes',
            ],
            [
                'name'        => 'HR and Administrative Department',
                'code'        => 'HRAD',
                'description' => 'Handles human resources, administration, and general office management.',
                'head_name'   => 'Pedro Bautista',
            ],
            [
                'name'        => 'Galley Operations Department',
                'code'        => 'GOD',
                'description' => 'Manages food preparation, kitchen equipment, and food supply inventories.',
                'head_name'   => 'Rosa Villanueva',
            ],
            [
                'name'        => 'Dormitory Operations Department',
                'code'        => 'DOD',
                'description' => 'Oversees dormitory facilities, bedding, and occupant support.',
                'head_name'   => 'Lucia Torres',
            ],
            [
                'name'        => 'Finance Department',
                'code'        => 'FIN',
                'description' => 'Handles financial management, accounting, and budget control.',
                'head_name'   => 'Miguel Aquino',
            ],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['code' => $dept['code']], $dept);
        }
    }
}
