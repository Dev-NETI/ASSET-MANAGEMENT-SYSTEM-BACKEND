<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name'           => 'TechHub Supplies Inc.',
                'contact_person' => 'Ramon Diaz',
                'email'          => 'sales@techHub.com',
                'phone'          => '0917-555-1001',
                'address'        => '123 Ayala Ave., Makati City',
            ],
            [
                'name'           => 'UniForm Pro Philippines',
                'contact_person' => 'Celia Ramos',
                'email'          => 'orders@uniformpro.ph',
                'phone'          => '0918-555-1002',
                'address'        => '45 Blumentritt St., Manila',
            ],
            [
                'name'           => 'FreshMart Food Supplies',
                'contact_person' => 'Ernesto Cruz',
                'email'          => 'supply@freshmart.ph',
                'phone'          => '0919-555-1003',
                'address'        => 'Public Market, Divisoria, Manila',
            ],
            [
                'name'           => 'Office World Philippines',
                'contact_person' => 'Vanessa Lim',
                'email'          => 'corporate@officeworld.ph',
                'phone'          => '0920-555-1004',
                'address'        => '78 E. Rodriguez Ave., Quezon City',
            ],
            [
                'name'           => 'HomeLinens Co.',
                'contact_person' => 'Patricia Sy',
                'email'          => 'orders@homelinens.com',
                'phone'          => '0921-555-1005',
                'address'        => '22 Bagtikan St., Makati City',
            ],
            [
                'name'           => 'KitchenPro Philippines',
                'contact_person' => 'Bernard Tan',
                'email'          => 'sales@kitchenpro.ph',
                'phone'          => '0922-555-1006',
                'address'        => '99 Espana Blvd., Manila',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(['name' => $supplier['name']], $supplier);
        }
    }
}
