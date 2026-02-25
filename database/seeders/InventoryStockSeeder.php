<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\InventoryStock;
use App\Models\Item;
use App\Models\StockReceival;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class InventoryStockSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $dept  = fn (string $code) => Department::where('code', $code)->first()?->id;
        $item  = fn (string $name) => Item::where('name', $name)->first()?->id;
        $supp  = fn (string $name) => Supplier::where('name', 'like', "%{$name}%")->first()?->id;

        $stocks = [
            // ── BOD: Clothing ─────────────────────────────────────────────
            ['item' => 'Staff T-Shirt',    'dept' => 'BOD', 'qty' => 120, 'supplier' => 'UniForm Pro',   'unit_cost' => 250.00],
            ['item' => 'Staff Polo Shirt', 'dept' => 'BOD', 'qty' => 80,  'supplier' => 'UniForm Pro',   'unit_cost' => 350.00],
            // ── GOD: Food ─────────────────────────────────────────────────
            ['item' => 'Chicken Breast',         'dept' => 'GOD', 'qty' => 50,  'supplier' => 'FreshMart', 'unit_cost' => 180.00],
            ['item' => 'Pork Liempo (Belly)',     'dept' => 'GOD', 'qty' => 40,  'supplier' => 'FreshMart', 'unit_cost' => 220.00],
            ['item' => 'Fish Fillet (Tilapia)',   'dept' => 'GOD', 'qty' => 30,  'supplier' => 'FreshMart', 'unit_cost' => 150.00],
            ['item' => 'White Rice',              'dept' => 'GOD', 'qty' => 10,  'supplier' => 'FreshMart', 'unit_cost' => 2800.00],
            ['item' => 'Cooking Oil',             'dept' => 'GOD', 'qty' => 20,  'supplier' => 'FreshMart', 'unit_cost' => 95.00],
            ['item' => 'Dishwashing Liquid',      'dept' => 'GOD', 'qty' => 12,  'supplier' => 'FreshMart', 'unit_cost' => 65.00],
            // ── DOD: Bedding ──────────────────────────────────────────────
            ['item' => 'Blanket',          'dept' => 'DOD', 'qty' => 200, 'supplier' => 'HomeLinens',    'unit_cost' => 350.00],
            ['item' => 'Pillow',           'dept' => 'DOD', 'qty' => 150, 'supplier' => 'HomeLinens',    'unit_cost' => 250.00],
            ['item' => 'Bed Sheet Set',    'dept' => 'DOD', 'qty' => 120, 'supplier' => 'HomeLinens',    'unit_cost' => 450.00],
            // ── HRAD: Office Supplies ─────────────────────────────────────
            ['item' => 'Bond Paper (A4)',           'dept' => 'HRAD', 'qty' => 50,  'supplier' => 'Office World', 'unit_cost' => 280.00],
            ['item' => 'Ballpen',                  'dept' => 'HRAD', 'qty' => 10,  'supplier' => 'Office World', 'unit_cost' => 85.00],
            ['item' => 'Printer Ink Cartridge (Black)', 'dept' => 'HRAD', 'qty' => 5, 'supplier' => 'Office World', 'unit_cost' => 650.00],
            // ── PRPD: Office Supplies ─────────────────────────────────────
            ['item' => 'Bond Paper (A4)', 'dept' => 'PRPD', 'qty' => 30, 'supplier' => 'Office World', 'unit_cost' => 280.00],
            ['item' => 'Ballpen',         'dept' => 'PRPD', 'qty' => 5,  'supplier' => 'Office World', 'unit_cost' => 85.00],
            // ── FIN: Office Supplies ──────────────────────────────────────
            ['item' => 'Bond Paper (A4)', 'dept' => 'FIN',  'qty' => 20, 'supplier' => 'Office World', 'unit_cost' => 280.00],
            ['item' => 'Ballpen',         'dept' => 'FIN',  'qty' => 3,  'supplier' => 'Office World', 'unit_cost' => 85.00],
            // ── NOD: Office Supplies ──────────────────────────────────────
            ['item' => 'Bond Paper (A4)', 'dept' => 'NOD',  'qty' => 10, 'supplier' => 'Office World', 'unit_cost' => 280.00],
            // ── BOD: Office Supplies ──────────────────────────────────────
            ['item' => 'Bond Paper (A4)', 'dept' => 'BOD',  'qty' => 15, 'supplier' => 'Office World', 'unit_cost' => 280.00],
        ];

        foreach ($stocks as $s) {
            $itemId = $item($s['item']);
            $deptId = $dept($s['dept']);

            if (! $itemId || ! $deptId) {
                continue;
            }

            // Upsert inventory stock
            InventoryStock::updateOrCreate(
                ['item_id' => $itemId, 'department_id' => $deptId],
                ['quantity' => $s['qty']]
            );

            // Record a matching stock receival for audit trail
            StockReceival::create([
                'item_id'       => $itemId,
                'department_id' => $deptId,
                'quantity'      => $s['qty'],
                'unit_cost'     => $s['unit_cost'],
                'supplier_id'   => $supp($s['supplier']),
                'reference_no'  => 'INIT-' . strtoupper($s['dept']) . '-001',
                'received_by'   => $admin->id,
                'received_at'   => now()->subDays(rand(7, 60)),
                'notes'         => 'Initial stock load',
            ]);
        }
    }
}
