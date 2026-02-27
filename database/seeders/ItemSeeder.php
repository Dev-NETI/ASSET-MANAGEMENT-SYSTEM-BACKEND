<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Department;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $pcs  = Unit::where('abbreviation', 'pcs')->first()->id;
        $kg   = Unit::where('abbreviation', 'kg')->first()->id;
        $L    = Unit::where('abbreviation', 'L')->first()->id;
        $set  = Unit::where('abbreviation', 'set')->first()->id;
        $ream = Unit::where('abbreviation', 'ream')->first()->id;
        $box  = Unit::where('abbreviation', 'box')->first()->id;
        $sack = Unit::where('abbreviation', 'sack')->first()->id;
        $btl  = Unit::where('abbreviation', 'btl')->first()->id;

        $dept = fn (string $code) => Department::where('code', $code)->first()?->id;

        // Resolve category by code AND department
        $cat = fn (string $catCode, string $deptCode) => Category::where('code', $catCode)
            ->where('department_id', $dept($deptCode))
            ->first()?->id;

        $items = [
            // ── FIXED ASSETS ──────────────────────────────────────────────
            // NOD – Laptops
            [
                'name'            => 'Laptop Computer',
                'description'     => 'General-purpose portable computer for staff use',
                'category_id'     => $cat('ELEC-LAP', 'NOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'fixed_asset',
                'brand'           => 'Dell',
                'model'           => 'Inspiron 15 3000',
                'specifications'  => ['ram' => '16GB', 'storage' => '512GB SSD', 'os' => 'Windows 11'],
                'min_stock_level' => 0,
                'department_id'   => $dept('NOD'),
            ],
            // NOD – Desktops
            [
                'name'            => 'Desktop Computer',
                'description'     => 'Desktop workstation for office use',
                'category_id'     => $cat('ELEC-DES', 'NOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'fixed_asset',
                'brand'           => 'Dell',
                'model'           => 'OptiPlex 7090',
                'specifications'  => ['ram' => '32GB', 'storage' => '1TB HDD', 'os' => 'Windows 11'],
                'min_stock_level' => 0,
                'department_id'   => $dept('NOD'),
            ],
            // NOD – Tablets
            [
                'name'            => 'Tablet',
                'description'     => 'Tablet device for field and mobile use',
                'category_id'     => $cat('ELEC-TAB', 'NOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'fixed_asset',
                'brand'           => 'Apple',
                'model'           => 'iPad Pro 12.9"',
                'specifications'  => ['storage' => '256GB', 'connectivity' => 'Wi-Fi + LTE'],
                'min_stock_level' => 0,
                'department_id'   => $dept('NOD'),
            ],
            // NOD – Network Switch
            [
                'name'            => 'Network Switch',
                'description'     => '24-port managed network switch',
                'category_id'     => $cat('NETW-SWT', 'NOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'fixed_asset',
                'brand'           => 'Cisco',
                'model'           => 'Catalyst 2960-X',
                'specifications'  => ['ports' => '24', 'speed' => 'Gigabit'],
                'min_stock_level' => 0,
                'department_id'   => $dept('NOD'),
            ],
            // NOD – Server
            [
                'name'            => 'Server',
                'description'     => 'Rack-mounted application and file server',
                'category_id'     => $cat('NETW-SRV', 'NOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'fixed_asset',
                'brand'           => 'Dell',
                'model'           => 'PowerEdge R740',
                'specifications'  => ['cpu' => 'Xeon Silver 4210', 'ram' => '64GB', 'storage' => '4x 2TB HDD RAID'],
                'min_stock_level' => 0,
                'department_id'   => $dept('NOD'),
            ],
            // NOD – UPS
            [
                'name'            => 'Uninterruptible Power Supply (UPS)',
                'description'     => 'Battery backup for network equipment',
                'category_id'     => $cat('NETW-UPS', 'NOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'fixed_asset',
                'brand'           => 'APC',
                'model'           => 'Smart-UPS 1500VA',
                'specifications'  => ['capacity' => '1500VA', 'runtime' => '15 min at full load'],
                'min_stock_level' => 0,
                'department_id'   => $dept('NOD'),
            ],
            // GOD – Commercial Refrigerator
            [
                'name'            => 'Commercial Refrigerator',
                'description'     => 'Upright commercial refrigerator for food storage',
                'category_id'     => $cat('KTEQ-FST', 'GOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'fixed_asset',
                'brand'           => 'Toshiba',
                'model'           => 'GR-MG55SDZ',
                'specifications'  => ['capacity' => '550L', 'cooling' => 'Inverter'],
                'min_stock_level' => 0,
                'department_id'   => $dept('GOD'),
            ],
            // GOD – Gas Cooking Range
            [
                'name'            => 'Gas Cooking Range',
                'description'     => '6-burner commercial gas cooking range',
                'category_id'     => $cat('KTEQ-CKA', 'GOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'fixed_asset',
                'brand'           => 'Modena',
                'model'           => 'GS-C66',
                'specifications'  => ['burners' => '6', 'ignition' => 'Auto'],
                'min_stock_level' => 0,
                'department_id'   => $dept('GOD'),
            ],
            // HRAD – Office Desk
            [
                'name'            => 'Office Desk',
                'description'     => 'Standard office desk with drawers',
                'category_id'     => $cat('FURN', 'HRAD'),
                'unit_id'         => $pcs,
                'item_type'       => 'fixed_asset',
                'brand'           => null,
                'model'           => '120cm Executive Desk',
                'specifications'  => ['dimensions' => '120x60x75 cm', 'material' => 'Engineered wood'],
                'min_stock_level' => 0,
                'department_id'   => $dept('HRAD'),
            ],
            // HRAD – Office Chair
            [
                'name'            => 'Office Chair',
                'description'     => 'Ergonomic office chair with lumbar support',
                'category_id'     => $cat('FURN', 'HRAD'),
                'unit_id'         => $pcs,
                'item_type'       => 'fixed_asset',
                'brand'           => null,
                'model'           => 'Executive Mesh Chair',
                'specifications'  => ['type' => 'High-back mesh', 'adjustable' => true],
                'min_stock_level' => 0,
                'department_id'   => $dept('HRAD'),
            ],
            // DOD – Air Conditioning Unit
            [
                'name'            => 'Air Conditioning Unit',
                'description'     => 'Split-type air conditioner for dormitory rooms',
                'category_id'     => $cat('BDEQ', 'DOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'fixed_asset',
                'brand'           => 'Carrier',
                'model'           => '1.5HP Inverter',
                'specifications'  => ['capacity' => '1.5HP', 'type' => 'Split-type inverter'],
                'min_stock_level' => 0,
                'department_id'   => $dept('DOD'),
            ],
            // GOD – Cookware Set
            [
                'name'            => 'Cookware Set',
                'description'     => 'Complete set of pots and pans for commercial kitchen',
                'category_id'     => $cat('KTEQ-CKW', 'GOD'),
                'unit_id'         => $set,
                'item_type'       => 'fixed_asset',
                'brand'           => 'Meyer',
                'model'           => 'Commercial Pro Set',
                'specifications'  => ['pieces' => 12, 'material' => 'Stainless steel'],
                'min_stock_level' => 0,
                'department_id'   => $dept('GOD'),
            ],

            // ── CONSUMABLES ───────────────────────────────────────────────
            // BOD – T-Shirt
            [
                'name'            => 'Staff T-Shirt',
                'description'     => 'Company branded staff t-shirt (round neck)',
                'category_id'     => $cat('CLTH-TSH', 'BOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'consumable',
                'brand'           => null,
                'model'           => null,
                'specifications'  => ['material' => '100% Cotton', 'sizes' => 'XS-3XL'],
                'min_stock_level' => 20,
                'department_id'   => $dept('BOD'),
            ],
            // BOD – Polo Shirt
            [
                'name'            => 'Staff Polo Shirt',
                'description'     => 'Company branded polo shirt with collar',
                'category_id'     => $cat('CLTH-PLO', 'BOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'consumable',
                'brand'           => null,
                'model'           => null,
                'specifications'  => ['material' => 'Polycotton blend', 'sizes' => 'XS-3XL'],
                'min_stock_level' => 15,
                'department_id'   => $dept('BOD'),
            ],
            // GOD – Chicken Breast
            [
                'name'            => 'Chicken Breast',
                'description'     => 'Fresh boneless chicken breast, per kilogram',
                'category_id'     => $cat('FOOD-MPT', 'GOD'),
                'unit_id'         => $kg,
                'item_type'       => 'consumable',
                'brand'           => null,
                'model'           => null,
                'specifications'  => null,
                'min_stock_level' => 10,
                'department_id'   => $dept('GOD'),
            ],
            // GOD – Pork Liempo
            [
                'name'            => 'Pork Liempo (Belly)',
                'description'     => 'Fresh pork belly, per kilogram',
                'category_id'     => $cat('FOOD-MPT', 'GOD'),
                'unit_id'         => $kg,
                'item_type'       => 'consumable',
                'brand'           => null,
                'model'           => null,
                'specifications'  => null,
                'min_stock_level' => 10,
                'department_id'   => $dept('GOD'),
            ],
            // GOD – Fish Fillet
            [
                'name'            => 'Fish Fillet (Tilapia)',
                'description'     => 'Fresh tilapia fillet, per kilogram',
                'category_id'     => $cat('FOOD-SFD', 'GOD'),
                'unit_id'         => $kg,
                'item_type'       => 'consumable',
                'brand'           => null,
                'model'           => null,
                'specifications'  => null,
                'min_stock_level' => 8,
                'department_id'   => $dept('GOD'),
            ],
            // GOD – White Rice
            [
                'name'            => 'White Rice',
                'description'     => 'Premium white rice, sold per sack (50kg)',
                'category_id'     => $cat('FOOD-DRY', 'GOD'),
                'unit_id'         => $sack,
                'item_type'       => 'consumable',
                'brand'           => 'Sinandomeng',
                'model'           => null,
                'specifications'  => ['weight_per_sack' => '50kg'],
                'min_stock_level' => 5,
                'department_id'   => $dept('GOD'),
            ],
            // GOD – Cooking Oil
            [
                'name'            => 'Cooking Oil',
                'description'     => 'Refined vegetable cooking oil',
                'category_id'     => $cat('FOOD-CND', 'GOD'),
                'unit_id'         => $L,
                'item_type'       => 'consumable',
                'brand'           => 'Golden Fiesta',
                'model'           => null,
                'specifications'  => null,
                'min_stock_level' => 10,
                'department_id'   => $dept('GOD'),
            ],
            // DOD – Blanket
            [
                'name'            => 'Blanket',
                'description'     => 'Single-size sleeping blanket for dormitory',
                'category_id'     => $cat('BDLN-BLK', 'DOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'consumable',
                'brand'           => null,
                'model'           => 'Single Fleece Blanket',
                'specifications'  => ['size' => '150x200 cm', 'material' => 'Fleece'],
                'min_stock_level' => 30,
                'department_id'   => $dept('DOD'),
            ],
            // DOD – Pillow
            [
                'name'            => 'Pillow',
                'description'     => 'Standard sleeping pillow for dormitory',
                'category_id'     => $cat('BDLN-PLW', 'DOD'),
                'unit_id'         => $pcs,
                'item_type'       => 'consumable',
                'brand'           => null,
                'model'           => 'Standard Foam Pillow',
                'specifications'  => ['fill' => 'Foam fiber'],
                'min_stock_level' => 30,
                'department_id'   => $dept('DOD'),
            ],
            // DOD – Bed Sheet Set
            [
                'name'            => 'Bed Sheet Set',
                'description'     => 'Single-bed sheet set with pillow case',
                'category_id'     => $cat('BDLN-BSH', 'DOD'),
                'unit_id'         => $set,
                'item_type'       => 'consumable',
                'brand'           => null,
                'model'           => null,
                'specifications'  => ['includes' => '1 flat sheet, 1 pillow case'],
                'min_stock_level' => 20,
                'department_id'   => $dept('DOD'),
            ],
            // PRPD – Bond Paper
            [
                'name'            => 'Bond Paper (A4)',
                'description'     => 'A4 size 80gsm bond paper, per ream (500 sheets)',
                'category_id'     => $cat('OFSP-PPR', 'PRPD'),
                'unit_id'         => $ream,
                'item_type'       => 'consumable',
                'brand'           => 'Navigator',
                'model'           => null,
                'specifications'  => ['size' => 'A4', 'gsm' => '80', 'sheets_per_ream' => 500],
                'min_stock_level' => 5,
                'department_id'   => $dept('PRPD'),
            ],
            // PRPD – Ballpen
            [
                'name'            => 'Ballpen',
                'description'     => 'Standard black ballpen, sold per box of 12',
                'category_id'     => $cat('OFSP-WRT', 'PRPD'),
                'unit_id'         => $box,
                'item_type'       => 'consumable',
                'brand'           => 'Pilot',
                'model'           => 'BP-S Fine',
                'specifications'  => ['color' => 'black', 'tip' => 'fine', 'per_box' => 12],
                'min_stock_level' => 2,
                'department_id'   => $dept('PRPD'),
            ],
            // GOD – Dishwashing Liquid
            [
                'name'            => 'Dishwashing Liquid',
                'description'     => 'Heavy-duty commercial dishwashing liquid',
                'category_id'     => $cat('CLNS', 'GOD'),
                'unit_id'         => $btl,
                'item_type'       => 'consumable',
                'brand'           => 'Joy',
                'model'           => 'Antibacterial 1L',
                'specifications'  => ['volume' => '1L'],
                'min_stock_level' => 5,
                'department_id'   => $dept('GOD'),
            ],
            // PRPD – Printer Ink Cartridge
            [
                'name'            => 'Printer Ink Cartridge (Black)',
                'description'     => 'Compatible black ink cartridge for office printers',
                'category_id'     => $cat('OFSP-INK', 'PRPD'),
                'unit_id'         => $pcs,
                'item_type'       => 'consumable',
                'brand'           => 'Epson',
                'model'           => '003 Black',
                'specifications'  => ['color' => 'black', 'compatible' => 'L3110, L3210'],
                'min_stock_level' => 3,
                'department_id'   => $dept('PRPD'),
            ],
        ];

        foreach ($items as $itemData) {
            if ($itemData['category_id'] && $itemData['department_id']) {
                Item::firstOrCreate(
                    ['name' => $itemData['name'], 'department_id' => $itemData['department_id']],
                    $itemData
                );
            }
        }
    }
}
