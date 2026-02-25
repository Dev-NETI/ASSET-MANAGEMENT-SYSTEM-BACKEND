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
        $dept = fn (string $code) => Department::where('code', $code)->first()?->id;

        $users = [
            [
                'name'     => 'NOD Administrator',
                'email'    => 'nod@inventory.com',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'BOD Administrator',
                'email'    => 'bod@inventory.com',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'PRPD Administrator',
                'email'    => 'prpd@inventory.com',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'HRAD Administrator',
                'email'    => 'hrad@inventory.com',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'GOD Administrator',
                'email'    => 'god@inventory.com',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'DOD Administrator',
                'email'    => 'dod@inventory.com',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'Finance Administrator',
                'email'    => 'fin@inventory.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
