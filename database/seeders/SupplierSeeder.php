<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $dept = fn (string $code) => Department::where('code', $code)->first()?->id;

        $suppliers = [
            [
                'name'           => 'TechHub Supplies Inc.',
                'contact_person' => 'Ramon Diaz',
                'email'          => 'sales@techHub.com',
                'phone'          => '0917-555-1001',
                'address'        => '123 Ayala Ave., Makati City',
                'department_id'  => $dept('NOD'),
            ],
            [
                'name'           => 'UniForm Pro Philippines',
                'contact_person' => 'Celia Ramos',
                'email'          => 'orders@uniformpro.ph',
                'phone'          => '0918-555-1002',
                'address'        => '45 Blumentritt St., Manila',
                'department_id'  => $dept('BOD'),
            ],
            [
                'name'           => 'FreshMart Food Supplies',
                'contact_person' => 'Ernesto Cruz',
                'email'          => 'supply@freshmart.ph',
                'phone'          => '0919-555-1003',
                'address'        => 'Public Market, Divisoria, Manila',
                'department_id'  => $dept('GOD'),
            ],
            [
                'name'           => 'Office World Philippines',
                'contact_person' => 'Vanessa Lim',
                'email'          => 'corporate@officeworld.ph',
                'phone'          => '0920-555-1004',
                'address'        => '78 E. Rodriguez Ave., Quezon City',
                'department_id'  => $dept('PRPD'),
            ],
            [
                'name'           => 'HomeLinens Co.',
                'contact_person' => 'Patricia Sy',
                'email'          => 'orders@homelinens.com',
                'phone'          => '0921-555-1005',
                'address'        => '22 Bagtikan St., Makati City',
                'department_id'  => $dept('DOD'),
            ],
            [
                'name'           => 'KitchenPro Philippines',
                'contact_person' => 'Bernard Tan',
                'email'          => 'sales@kitchenpro.ph',
                'phone'          => '0922-555-1006',
                'address'        => '99 Espana Blvd., Manila',
                'department_id'  => $dept('GOD'),
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(
                ['name' => $supplier['name']],
                $supplier
            );
        }
    }
}
