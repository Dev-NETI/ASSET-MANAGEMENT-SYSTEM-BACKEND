<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'sherwin.roxas@neti.com.ph'],
            [
                'name'      => 'System Admin',
                'password'  => Hash::make('password'),
                'user_type' => 'system_administrator',
            ]
        );

        User::updateOrCreate(
            ['email' => 'sherwin.roxas@neti.com.ph'],
            ['user_type' => 'system_administrator']
        );

        User::firstOrCreate(
            ['email' => 'storekeeper@neti.com.ph'],
            [
                'name'      => 'Store Keeper',
                'password'  => Hash::make('password'),
                'user_type' => 'system_administrator',
            ]
        );

        User::updateOrCreate(
            ['email' => 'storekeeper@neti.com.ph'],
            ['user_type' => 'system_administrator']
        );
    }
}
