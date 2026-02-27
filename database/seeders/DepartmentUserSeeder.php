<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DepartmentUserSeeder extends Seeder
{
    public function run(): void
    {
        $dept = fn(string $code) => Department::where('code', $code)->first()?->id;

        $defaultPermissions = json_encode([
            'categories',
            'suppliers',
            'items',
            'item-assets',
            'asset-assignments',
            'inventory-stocks',
            'stock-receivals',
            'stock-issuances',
        ]);

        $users = [
            [
                'name'          => 'NOD Administrator',
                'email'         => 'nod@neti.com.ph',
                'password'      => Hash::make('password'),
                'user_type'     => 'employee',
                'department_id' => $dept('NOD'),
                'permissions'   => $defaultPermissions,
            ],
            [
                'name'          => 'BOD Administrator',
                'email'         => 'bod@neti.com.ph',
                'password'      => Hash::make('password'),
                'user_type'     => 'employee',
                'department_id' => $dept('BOD'),
                'permissions'   => $defaultPermissions,
            ],
            [
                'name'          => 'PRPD Administrator',
                'email'         => 'prpd@neti.com.ph',
                'password'      => Hash::make('password'),
                'user_type'     => 'employee',
                'department_id' => $dept('PRPD'),
                'permissions'   => $defaultPermissions,
            ],
            [
                'name'          => 'HRAD Administrator',
                'email'         => 'hrad@neti.com.ph',
                'password'      => Hash::make('password'),
                'user_type'     => 'employee',
                'department_id' => $dept('HRAD'),
                'permissions'   => $defaultPermissions,
            ],
            [
                'name'          => 'GOD Administrator',
                'email'         => 'god@neti.com.ph',
                'password'      => Hash::make('password'),
                'user_type'     => 'employee',
                'department_id' => $dept('GOD'),
                'permissions'   => $defaultPermissions,
            ],
            [
                'name'          => 'DOD Administrator',
                'email'         => 'dod@neti.com.ph',
                'password'      => Hash::make('password'),
                'user_type'     => 'employee',
                'department_id' => $dept('DOD'),
                'permissions'   => $defaultPermissions,
            ],
            [
                'name'          => 'Finance Administrator',
                'email'         => 'fin@neti.com.ph',
                'password'      => Hash::make('password'),
                'user_type'     => 'employee',
                'department_id' => $dept('FIN'),
                'permissions'   => $defaultPermissions,
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
