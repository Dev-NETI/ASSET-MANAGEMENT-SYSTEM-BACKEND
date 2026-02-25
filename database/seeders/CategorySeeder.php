<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Parent categories
        $parents = [
            ['name' => 'Electronics',           'code' => 'ELEC',  'description' => 'Electronic devices and gadgets'],
            ['name' => 'Network Equipment',      'code' => 'NETW',  'description' => 'Networking hardware and infrastructure'],
            ['name' => 'Clothing & Uniforms',    'code' => 'CLTH',  'description' => 'Uniforms, t-shirts, and work clothing'],
            ['name' => 'Office Supplies',        'code' => 'OFSP',  'description' => 'Stationery, paper, and office consumables'],
            ['name' => 'Kitchen Equipment',      'code'  => 'KTEQ', 'description' => 'Cooking appliances and kitchen tools'],
            ['name' => 'Food Items',             'code' => 'FOOD',  'description' => 'Raw ingredients and consumable food supplies'],
            ['name' => 'Bedding & Linens',       'code' => 'BDLN',  'description' => 'Blankets, pillows, bed sheets, and linens'],
            ['name' => 'Furniture',              'code' => 'FURN',  'description' => 'Tables, chairs, desks, and other furniture'],
            ['name' => 'Cleaning Supplies',      'code' => 'CLNS',  'description' => 'Detergents, disinfectants, and cleaning tools'],
            ['name' => 'Medical & First Aid',    'code' => 'MFAS',  'description' => 'First aid supplies and basic medical items'],
        ];

        foreach ($parents as $parent) {
            Category::firstOrCreate(['code' => $parent['code']], $parent);
        }

        // Sub-categories
        $children = [
            // Electronics
            ['name' => 'Laptops',           'code' => 'ELEC-LAP', 'description' => 'Portable computers', 'parent_code' => 'ELEC'],
            ['name' => 'Desktops',          'code' => 'ELEC-DES', 'description' => 'Desktop computers', 'parent_code' => 'ELEC'],
            ['name' => 'Tablets',           'code' => 'ELEC-TAB', 'description' => 'Tablet computers', 'parent_code' => 'ELEC'],
            ['name' => 'Printers',          'code' => 'ELEC-PRT', 'description' => 'Printers and scanners', 'parent_code' => 'ELEC'],
            ['name' => 'Monitors',          'code' => 'ELEC-MON', 'description' => 'Computer monitors and displays', 'parent_code' => 'ELEC'],
            // Network Equipment
            ['name' => 'Servers',           'code' => 'NETW-SRV', 'description' => 'Physical servers', 'parent_code' => 'NETW'],
            ['name' => 'Switches',          'code' => 'NETW-SWT', 'description' => 'Network switches', 'parent_code' => 'NETW'],
            ['name' => 'Routers',           'code' => 'NETW-RTR', 'description' => 'Network routers', 'parent_code' => 'NETW'],
            ['name' => 'UPS / Power',       'code' => 'NETW-UPS', 'description' => 'Uninterruptible power supplies', 'parent_code' => 'NETW'],
            // Clothing
            ['name' => 'T-Shirts',          'code' => 'CLTH-TSH', 'description' => 'Staff t-shirts', 'parent_code' => 'CLTH'],
            ['name' => 'Polo Shirts',       'code' => 'CLTH-PLO', 'description' => 'Polo shirts', 'parent_code' => 'CLTH'],
            ['name' => 'Work Pants',        'code' => 'CLTH-PNT', 'description' => 'Work trousers', 'parent_code' => 'CLTH'],
            // Office Supplies
            ['name' => 'Paper & Forms',     'code' => 'OFSP-PPR', 'description' => 'Bond paper, forms', 'parent_code' => 'OFSP'],
            ['name' => 'Writing Materials', 'code' => 'OFSP-WRT', 'description' => 'Pens, pencils, markers', 'parent_code' => 'OFSP'],
            ['name' => 'Binders & Folders', 'code' => 'OFSP-BND', 'description' => 'Folders, binders, clips', 'parent_code' => 'OFSP'],
            ['name' => 'Ink & Toner',       'code' => 'OFSP-INK', 'description' => 'Printer ink cartridges and toner', 'parent_code' => 'OFSP'],
            // Kitchen Equipment
            ['name' => 'Cooking Appliances','code' => 'KTEQ-CKA', 'description' => 'Gas range, oven, deep fryer', 'parent_code' => 'KTEQ'],
            ['name' => 'Food Storage',      'code' => 'KTEQ-FST', 'description' => 'Refrigerators, freezers', 'parent_code' => 'KTEQ'],
            ['name' => 'Cookware & Utensils','code'=> 'KTEQ-CKW', 'description' => 'Pots, pans, knives, ladles', 'parent_code' => 'KTEQ'],
            // Food Items
            ['name' => 'Meat & Poultry',    'code' => 'FOOD-MPT', 'description' => 'Beef, pork, chicken', 'parent_code' => 'FOOD'],
            ['name' => 'Seafood',           'code' => 'FOOD-SFD', 'description' => 'Fish, shrimp, squid', 'parent_code' => 'FOOD'],
            ['name' => 'Vegetables & Fruits','code'=> 'FOOD-VGT', 'description' => 'Fresh produce', 'parent_code' => 'FOOD'],
            ['name' => 'Dry Goods',         'code' => 'FOOD-DRY', 'description' => 'Rice, flour, sugar, canned goods', 'parent_code' => 'FOOD'],
            ['name' => 'Condiments & Spices','code'=> 'FOOD-CND', 'description' => 'Oil, soy sauce, spices', 'parent_code' => 'FOOD'],
            // Bedding
            ['name' => 'Blankets',          'code' => 'BDLN-BLK', 'description' => 'Sleeping blankets', 'parent_code' => 'BDLN'],
            ['name' => 'Pillows',           'code' => 'BDLN-PLW', 'description' => 'Sleeping pillows', 'parent_code' => 'BDLN'],
            ['name' => 'Bed Sheets',        'code' => 'BDLN-BSH', 'description' => 'Bed sheets and pillow cases', 'parent_code' => 'BDLN'],
            ['name' => 'Towels',            'code' => 'BDLN-TWL', 'description' => 'Bath and hand towels', 'parent_code' => 'BDLN'],
        ];

        foreach ($children as $child) {
            $parent = Category::where('code', $child['parent_code'])->first();
            if ($parent) {
                Category::firstOrCreate(
                    ['code' => $child['code']],
                    [
                        'name'        => $child['name'],
                        'description' => $child['description'],
                        'parent_id'   => $parent->id,
                    ]
                );
            }
        }
    }
}
