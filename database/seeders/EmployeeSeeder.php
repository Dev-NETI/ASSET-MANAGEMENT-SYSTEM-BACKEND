<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $dept = fn (string $code) => Department::where('code', $code)->first()?->id;

        $employees = [
            // NOD
            ['first_name' => 'Juan',    'last_name' => 'Dela Cruz',   'department_id' => $dept('NOD'),  'position' => 'IT Engineer',              'phone' => '0917-001-0001', 'status' => 'active'],
            ['first_name' => 'Maria',   'last_name' => 'Santos',      'department_id' => $dept('NOD'),  'position' => 'Network Administrator',    'phone' => '0917-001-0002', 'status' => 'active'],
            ['first_name' => 'Ramon',   'last_name' => 'Garcia',      'department_id' => $dept('NOD'),  'position' => 'Systems Analyst',          'phone' => '0917-001-0003', 'status' => 'active'],
            // BOD
            ['first_name' => 'Jose',    'last_name' => 'Reyes',       'department_id' => $dept('BOD'),  'position' => 'Operations Officer',       'phone' => '0918-001-0001', 'status' => 'active'],
            ['first_name' => 'Clara',   'last_name' => 'Mendoza',     'department_id' => $dept('BOD'),  'position' => 'Operations Staff',         'phone' => '0918-001-0002', 'status' => 'active'],
            // PRPD
            ['first_name' => 'Ana',     'last_name' => 'Bautista',    'department_id' => $dept('PRPD'), 'position' => 'Research Analyst',         'phone' => '0919-001-0001', 'status' => 'active'],
            ['first_name' => 'Victor',  'last_name' => 'Navarro',     'department_id' => $dept('PRPD'), 'position' => 'Program Developer',        'phone' => '0919-001-0002', 'status' => 'active'],
            // HRAD
            ['first_name' => 'Pedro',   'last_name' => 'Aguilar',     'department_id' => $dept('HRAD'), 'position' => 'HR Officer',               'phone' => '0920-001-0001', 'status' => 'active'],
            ['first_name' => 'Teresa',  'last_name' => 'Flores',      'department_id' => $dept('HRAD'), 'position' => 'Administrative Assistant', 'phone' => '0920-001-0002', 'status' => 'active'],
            // GOD
            ['first_name' => 'Rosa',    'last_name' => 'Villanueva',  'department_id' => $dept('GOD'),  'position' => 'Head Chef',                'phone' => '0921-001-0001', 'status' => 'active'],
            ['first_name' => 'Carlos',  'last_name' => 'Fernandez',   'department_id' => $dept('GOD'),  'position' => 'Sous Chef',                'phone' => '0921-001-0002', 'status' => 'active'],
            ['first_name' => 'Elena',   'last_name' => 'Castillo',    'department_id' => $dept('GOD'),  'position' => 'Kitchen Staff',            'phone' => '0921-001-0003', 'status' => 'active'],
            // DOD
            ['first_name' => 'Lucia',   'last_name' => 'Torres',      'department_id' => $dept('DOD'),  'position' => 'Dormitory Supervisor',     'phone' => '0922-001-0001', 'status' => 'active'],
            ['first_name' => 'Andres',  'last_name' => 'Ramos',       'department_id' => $dept('DOD'),  'position' => 'Dormitory Staff',          'phone' => '0922-001-0002', 'status' => 'active'],
            // FIN
            ['first_name' => 'Miguel',  'last_name' => 'Aquino',      'department_id' => $dept('FIN'),  'position' => 'Finance Officer',          'phone' => '0923-001-0001', 'status' => 'active'],
            ['first_name' => 'Rosario', 'last_name' => 'Cruz',        'department_id' => $dept('FIN'),  'position' => 'Accountant',               'phone' => '0923-001-0002', 'status' => 'active'],
        ];

        foreach ($employees as $employee) {
            if ($employee['department_id']) {
                Employee::firstOrCreate(
                    [
                        'first_name'    => $employee['first_name'],
                        'last_name'     => $employee['last_name'],
                        'department_id' => $employee['department_id'],
                    ],
                    $employee
                );
            }
        }
    }
}
