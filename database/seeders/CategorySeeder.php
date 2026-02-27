<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Department;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $dept = fn (string $code) => Department::where('code', $code)->first()?->id;

        $categories = [
            // NOD — IT Hardware
            ['name' => 'Laptops',             'code' => 'ELEC-LAP',  'description' => 'Portable computers',                     'dept' => 'NOD'],
            ['name' => 'Desktops',            'code' => 'ELEC-DES',  'description' => 'Desktop computers',                      'dept' => 'NOD'],
            ['name' => 'Tablets',             'code' => 'ELEC-TAB',  'description' => 'Tablet computers',                       'dept' => 'NOD'],
            ['name' => 'Printers',            'code' => 'ELEC-PRT',  'description' => 'Printers and scanners',                  'dept' => 'NOD'],
            ['name' => 'Monitors',            'code' => 'ELEC-MON',  'description' => 'Computer monitors and displays',         'dept' => 'NOD'],
            ['name' => 'Servers',             'code' => 'NETW-SRV',  'description' => 'Physical servers',                       'dept' => 'NOD'],
            ['name' => 'Switches',            'code' => 'NETW-SWT',  'description' => 'Network switches',                       'dept' => 'NOD'],
            ['name' => 'Routers',             'code' => 'NETW-RTR',  'description' => 'Network routers',                        'dept' => 'NOD'],
            ['name' => 'UPS / Power',         'code' => 'NETW-UPS',  'description' => 'Uninterruptible power supplies',         'dept' => 'NOD'],
            // BOD — Clothing
            ['name' => 'T-Shirts',            'code' => 'CLTH-TSH',  'description' => 'Staff t-shirts',                         'dept' => 'BOD'],
            ['name' => 'Polo Shirts',         'code' => 'CLTH-PLO',  'description' => 'Polo shirts',                            'dept' => 'BOD'],
            ['name' => 'Work Pants',          'code' => 'CLTH-PNT',  'description' => 'Work trousers',                          'dept' => 'BOD'],
            // PRPD — Office Supplies
            ['name' => 'Paper & Forms',       'code' => 'OFSP-PPR',  'description' => 'Bond paper, forms',                      'dept' => 'PRPD'],
            ['name' => 'Writing Materials',   'code' => 'OFSP-WRT',  'description' => 'Pens, pencils, markers',                 'dept' => 'PRPD'],
            ['name' => 'Binders & Folders',   'code' => 'OFSP-BND',  'description' => 'Folders, binders, clips',                'dept' => 'PRPD'],
            ['name' => 'Ink & Toner',         'code' => 'OFSP-INK',  'description' => 'Printer ink cartridges and toner',       'dept' => 'PRPD'],
            // HRAD — Furniture & Medical
            ['name' => 'Furniture',           'code' => 'FURN',      'description' => 'Tables, chairs, desks, and other furniture', 'dept' => 'HRAD'],
            ['name' => 'Medical & First Aid', 'code' => 'MFAS',      'description' => 'First aid supplies and basic medical items',  'dept' => 'HRAD'],
            // GOD — Kitchen & Food
            ['name' => 'Cooking Appliances',  'code' => 'KTEQ-CKA',  'description' => 'Gas range, oven, deep fryer',            'dept' => 'GOD'],
            ['name' => 'Food Storage',        'code' => 'KTEQ-FST',  'description' => 'Refrigerators, freezers',                'dept' => 'GOD'],
            ['name' => 'Cookware & Utensils', 'code' => 'KTEQ-CKW',  'description' => 'Pots, pans, knives, ladles',             'dept' => 'GOD'],
            ['name' => 'Meat & Poultry',      'code' => 'FOOD-MPT',  'description' => 'Beef, pork, chicken',                    'dept' => 'GOD'],
            ['name' => 'Seafood',             'code' => 'FOOD-SFD',  'description' => 'Fish, shrimp, squid',                    'dept' => 'GOD'],
            ['name' => 'Vegetables & Fruits', 'code' => 'FOOD-VGT',  'description' => 'Fresh produce',                          'dept' => 'GOD'],
            ['name' => 'Dry Goods',           'code' => 'FOOD-DRY',  'description' => 'Rice, flour, sugar, canned goods',       'dept' => 'GOD'],
            ['name' => 'Condiments & Spices', 'code' => 'FOOD-CND',  'description' => 'Oil, soy sauce, spices',                 'dept' => 'GOD'],
            ['name' => 'Cleaning Supplies',   'code' => 'CLNS',      'description' => 'Detergents, disinfectants, cleaning tools', 'dept' => 'GOD'],
            // DOD — Bedding & Facilities
            ['name' => 'Blankets',            'code' => 'BDLN-BLK',  'description' => 'Sleeping blankets',                      'dept' => 'DOD'],
            ['name' => 'Pillows',             'code' => 'BDLN-PLW',  'description' => 'Sleeping pillows',                       'dept' => 'DOD'],
            ['name' => 'Bed Sheets',          'code' => 'BDLN-BSH',  'description' => 'Bed sheets and pillow cases',            'dept' => 'DOD'],
            ['name' => 'Towels',              'code' => 'BDLN-TWL',  'description' => 'Bath and hand towels',                   'dept' => 'DOD'],
            ['name' => 'Building Equipment',  'code' => 'BDEQ',      'description' => 'Air conditioning, fixtures, and building assets', 'dept' => 'DOD'],
        ];

        foreach ($categories as $cat) {
            $deptId = $dept($cat['dept']);
            Category::firstOrCreate(
                ['code' => $cat['code'], 'department_id' => $deptId],
                [
                    'name'          => $cat['name'],
                    'description'   => $cat['description'],
                    'department_id' => $deptId,
                ]
            );
        }
    }
}
