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
            ['employee_id' => 'EMP-001', 'first_name' => 'Juan',    'last_name' => 'Dela Cruz',   'department_id' => $dept('NOD'), 'position' => 'IT Engineer',             'email' => 'juan.delacruz@company.com',   'phone' => '0917-001-0001', 'status' => 'active'],
            ['employee_id' => 'EMP-002', 'first_name' => 'Maria',   'last_name' => 'Santos',      'department_id' => $dept('NOD'), 'position' => 'Network Administrator',   'email' => 'maria.santos@company.com',    'phone' => '0917-001-0002', 'status' => 'active'],
            ['employee_id' => 'EMP-003', 'first_name' => 'Ramon',   'last_name' => 'Garcia',      'department_id' => $dept('NOD'), 'position' => 'Systems Analyst',         'email' => 'ramon.garcia@company.com',    'phone' => '0917-001-0003', 'status' => 'active'],
            // BOD
            ['employee_id' => 'EMP-004', 'first_name' => 'Jose',    'last_name' => 'Reyes',       'department_id' => $dept('BOD'), 'position' => 'Operations Officer',      'email' => 'jose.reyes@company.com',      'phone' => '0918-001-0001', 'status' => 'active'],
            ['employee_id' => 'EMP-005', 'first_name' => 'Clara',   'last_name' => 'Mendoza',     'department_id' => $dept('BOD'), 'position' => 'Operations Staff',        'email' => 'clara.mendoza@company.com',   'phone' => '0918-001-0002', 'status' => 'active'],
            // PRPD
            ['employee_id' => 'EMP-006', 'first_name' => 'Ana',     'last_name' => 'Bautista',    'department_id' => $dept('PRPD'), 'position' => 'Research Analyst',       'email' => 'ana.bautista@company.com',    'phone' => '0919-001-0001', 'status' => 'active'],
            ['employee_id' => 'EMP-007', 'first_name' => 'Victor',  'last_name' => 'Navarro',     'department_id' => $dept('PRPD'), 'position' => 'Program Developer',      'email' => 'victor.navarro@company.com',  'phone' => '0919-001-0002', 'status' => 'active'],
            // HRAD
            ['employee_id' => 'EMP-008', 'first_name' => 'Pedro',   'last_name' => 'Aguilar',     'department_id' => $dept('HRAD'), 'position' => 'HR Officer',             'email' => 'pedro.aguilar@company.com',   'phone' => '0920-001-0001', 'status' => 'active'],
            ['employee_id' => 'EMP-009', 'first_name' => 'Teresa',  'last_name' => 'Flores',      'department_id' => $dept('HRAD'), 'position' => 'Administrative Assistant','email' => 'teresa.flores@company.com',  'phone' => '0920-001-0002', 'status' => 'active'],
            // GOD
            ['employee_id' => 'EMP-010', 'first_name' => 'Rosa',    'last_name' => 'Villanueva',  'department_id' => $dept('GOD'), 'position' => 'Head Chef',               'email' => 'rosa.villanueva@company.com', 'phone' => '0921-001-0001', 'status' => 'active'],
            ['employee_id' => 'EMP-011', 'first_name' => 'Carlos',  'last_name' => 'Fernandez',   'department_id' => $dept('GOD'), 'position' => 'Sous Chef',               'email' => 'carlos.fernandez@company.com','phone' => '0921-001-0002', 'status' => 'active'],
            ['employee_id' => 'EMP-012', 'first_name' => 'Elena',   'last_name' => 'Castillo',    'department_id' => $dept('GOD'), 'position' => 'Kitchen Staff',           'email' => 'elena.castillo@company.com',  'phone' => '0921-001-0003', 'status' => 'active'],
            // DOD
            ['employee_id' => 'EMP-013', 'first_name' => 'Lucia',   'last_name' => 'Torres',      'department_id' => $dept('DOD'), 'position' => 'Dormitory Supervisor',    'email' => 'lucia.torres@company.com',    'phone' => '0922-001-0001', 'status' => 'active'],
            ['employee_id' => 'EMP-014', 'first_name' => 'Andres',  'last_name' => 'Ramos',       'department_id' => $dept('DOD'), 'position' => 'Dormitory Staff',         'email' => 'andres.ramos@company.com',    'phone' => '0922-001-0002', 'status' => 'active'],
            // FIN
            ['employee_id' => 'EMP-015', 'first_name' => 'Miguel',  'last_name' => 'Aquino',      'department_id' => $dept('FIN'), 'position' => 'Finance Officer',         'email' => 'miguel.aquino@company.com',   'phone' => '0923-001-0001', 'status' => 'active'],
            ['employee_id' => 'EMP-016', 'first_name' => 'Rosario', 'last_name' => 'Cruz',        'department_id' => $dept('FIN'), 'position' => 'Accountant',              'email' => 'rosario.cruz@company.com',    'phone' => '0923-001-0002', 'status' => 'active'],
        ];

        foreach ($employees as $employee) {
            if ($employee['department_id']) {
                Employee::firstOrCreate(['employee_id' => $employee['employee_id']], $employee);
            }
        }
    }
}
