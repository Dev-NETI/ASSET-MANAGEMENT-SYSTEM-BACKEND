<?php

namespace Database\Seeders;

use App\Models\AssetAssignment;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Item;
use App\Models\ItemAsset;
use App\Models\User;
use Illuminate\Database\Seeder;

class ItemAssetSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $dept  = fn (string $code) => Department::where('code', $code)->first()?->id;
        $item  = fn (string $name) => Item::where('name', $name)->first()?->id;
        $emp   = fn (string $eid) => Employee::where('employee_id', $eid)->first();

        $assets = [
            // ── Laptops (NOD) ─────────────────────────────────────────────
            ['item_code' => 'NOD-LAP-001', 'item' => 'Laptop Computer', 'serial' => 'DL-INS-SN00101', 'dept' => 'NOD', 'purchase_date' => '2024-01-15', 'purchase_price' => 55000.00, 'condition' => 'good',  'status' => 'assigned', 'assignee' => 'EMP-001'],
            ['item_code' => 'NOD-LAP-002', 'item' => 'Laptop Computer', 'serial' => 'DL-INS-SN00102', 'dept' => 'NOD', 'purchase_date' => '2024-01-15', 'purchase_price' => 55000.00, 'condition' => 'good',  'status' => 'assigned', 'assignee' => 'EMP-002'],
            ['item_code' => 'NOD-LAP-003', 'item' => 'Laptop Computer', 'serial' => 'DL-INS-SN00103', 'dept' => 'NOD', 'purchase_date' => '2024-03-20', 'purchase_price' => 57500.00, 'condition' => 'new',   'status' => 'available', 'assignee' => null],
            ['item_code' => 'NOD-LAP-004', 'item' => 'Laptop Computer', 'serial' => 'DL-INS-SN00104', 'dept' => 'NOD', 'purchase_date' => '2024-03-20', 'purchase_price' => 57500.00, 'condition' => 'good',  'status' => 'assigned', 'assignee' => 'EMP-003'],
            // ── Desktops (NOD) ────────────────────────────────────────────
            ['item_code' => 'NOD-DES-001', 'item' => 'Desktop Computer', 'serial' => 'DL-OPX-SN00201', 'dept' => 'NOD', 'purchase_date' => '2023-06-10', 'purchase_price' => 45000.00, 'condition' => 'good',  'status' => 'available', 'assignee' => null],
            ['item_code' => 'NOD-DES-002', 'item' => 'Desktop Computer', 'serial' => 'DL-OPX-SN00202', 'dept' => 'NOD', 'purchase_date' => '2023-06-10', 'purchase_price' => 45000.00, 'condition' => 'fair',  'status' => 'under_repair', 'assignee' => null],
            // ── Tablets (NOD) ─────────────────────────────────────────────
            ['item_code' => 'NOD-TAB-001', 'item' => 'Tablet', 'serial' => 'AP-IPD-SN00301', 'dept' => 'NOD', 'purchase_date' => '2024-02-05', 'purchase_price' => 70000.00, 'condition' => 'good',  'status' => 'available', 'assignee' => null],
            // ── Network Switch (NOD) ──────────────────────────────────────
            ['item_code' => 'NOD-NSW-001', 'item' => 'Network Switch', 'serial' => 'CS-CAT-SN00401', 'dept' => 'NOD', 'purchase_date' => '2023-11-01', 'purchase_price' => 38000.00, 'condition' => 'good',  'status' => 'available', 'assignee' => null],
            ['item_code' => 'NOD-NSW-002', 'item' => 'Network Switch', 'serial' => 'CS-CAT-SN00402', 'dept' => 'NOD', 'purchase_date' => '2023-11-01', 'purchase_price' => 38000.00, 'condition' => 'good',  'status' => 'available', 'assignee' => null],
            // ── Server (NOD) ──────────────────────────────────────────────
            ['item_code' => 'NOD-SRV-001', 'item' => 'Server', 'serial' => 'DL-PER-SN00501', 'dept' => 'NOD', 'purchase_date' => '2023-09-15', 'purchase_price' => 280000.00, 'condition' => 'good',  'status' => 'available', 'assignee' => null],
            // ── UPS (NOD) ─────────────────────────────────────────────────
            ['item_code' => 'NOD-UPS-001', 'item' => 'Uninterruptible Power Supply (UPS)', 'serial' => 'APC-SU-SN00601', 'dept' => 'NOD', 'purchase_date' => '2023-09-15', 'purchase_price' => 18000.00, 'condition' => 'good',  'status' => 'available', 'assignee' => null],
            // ── Kitchen Equipment (GOD) ───────────────────────────────────
            ['item_code' => 'GOD-FRG-001', 'item' => 'Commercial Refrigerator', 'serial' => 'TSB-GRM-SN00701', 'dept' => 'GOD', 'purchase_date' => '2024-01-20', 'purchase_price' => 32000.00, 'condition' => 'good',  'status' => 'available', 'assignee' => null],
            ['item_code' => 'GOD-FRG-002', 'item' => 'Commercial Refrigerator', 'serial' => 'TSB-GRM-SN00702', 'dept' => 'GOD', 'purchase_date' => '2024-01-20', 'purchase_price' => 32000.00, 'condition' => 'good',  'status' => 'available', 'assignee' => null],
            ['item_code' => 'GOD-GCR-001', 'item' => 'Gas Cooking Range', 'serial' => 'MOD-GSC-SN00801', 'dept' => 'GOD', 'purchase_date' => '2024-01-20', 'purchase_price' => 25000.00, 'condition' => 'good',  'status' => 'available', 'assignee' => null],
            ['item_code' => 'GOD-CKW-001', 'item' => 'Cookware Set', 'serial' => null, 'dept' => 'GOD', 'purchase_date' => '2024-01-20', 'purchase_price' => 8500.00, 'condition' => 'good',  'status' => 'available', 'assignee' => null],
            // ── Furniture (HRAD) ──────────────────────────────────────────
            ['item_code' => 'HRAD-DSK-001', 'item' => 'Office Desk', 'serial' => null, 'dept' => 'HRAD', 'purchase_date' => '2023-04-10', 'purchase_price' => 8500.00,  'condition' => 'good',  'status' => 'assigned', 'assignee' => 'EMP-008'],
            ['item_code' => 'HRAD-DSK-002', 'item' => 'Office Desk', 'serial' => null, 'dept' => 'HRAD', 'purchase_date' => '2023-04-10', 'purchase_price' => 8500.00,  'condition' => 'good',  'status' => 'assigned', 'assignee' => 'EMP-009'],
            ['item_code' => 'HRAD-CHR-001', 'item' => 'Office Chair', 'serial' => null, 'dept' => 'HRAD', 'purchase_date' => '2023-04-10', 'purchase_price' => 5500.00,  'condition' => 'good',  'status' => 'assigned', 'assignee' => 'EMP-008'],
            ['item_code' => 'HRAD-CHR-002', 'item' => 'Office Chair', 'serial' => null, 'dept' => 'HRAD', 'purchase_date' => '2023-04-10', 'purchase_price' => 5500.00,  'condition' => 'good',  'status' => 'assigned', 'assignee' => 'EMP-009'],
            // ── Laptops for other departments ─────────────────────────────
            ['item_code' => 'PRPD-LAP-001', 'item' => 'Laptop Computer', 'serial' => 'DL-INS-SN00901', 'dept' => 'PRPD', 'purchase_date' => '2024-02-01', 'purchase_price' => 55000.00, 'condition' => 'good',  'status' => 'assigned', 'assignee' => 'EMP-006'],
            ['item_code' => 'PRPD-LAP-002', 'item' => 'Laptop Computer', 'serial' => 'DL-INS-SN00902', 'dept' => 'PRPD', 'purchase_date' => '2024-02-01', 'purchase_price' => 55000.00, 'condition' => 'good',  'status' => 'assigned', 'assignee' => 'EMP-007'],
            ['item_code' => 'FIN-LAP-001',  'item' => 'Laptop Computer', 'serial' => 'DL-INS-SN01001', 'dept' => 'FIN',  'purchase_date' => '2024-03-01', 'purchase_price' => 55000.00, 'condition' => 'new',   'status' => 'assigned', 'assignee' => 'EMP-015'],
            // ── AC Units (DOD) ────────────────────────────────────────────
            ['item_code' => 'DOD-ACU-001', 'item' => 'Air Conditioning Unit', 'serial' => 'CAR-1HP-SN01101', 'dept' => 'DOD', 'purchase_date' => '2023-05-01', 'purchase_price' => 28000.00, 'condition' => 'good',  'status' => 'available', 'assignee' => null],
            ['item_code' => 'DOD-ACU-002', 'item' => 'Air Conditioning Unit', 'serial' => 'CAR-1HP-SN01102', 'dept' => 'DOD', 'purchase_date' => '2023-05-01', 'purchase_price' => 28000.00, 'condition' => 'fair',  'status' => 'under_repair', 'assignee' => null],
            ['item_code' => 'DOD-ACU-003', 'item' => 'Air Conditioning Unit', 'serial' => 'CAR-1HP-SN01103', 'dept' => 'DOD', 'purchase_date' => '2024-01-10', 'purchase_price' => 30000.00, 'condition' => 'new',   'status' => 'available', 'assignee' => null],
        ];

        foreach ($assets as $assetData) {
            $itemId = $item($assetData['item']);
            $deptId = $dept($assetData['dept']);

            if (! $itemId || ! $deptId) {
                continue;
            }

            $asset = ItemAsset::firstOrCreate(
                ['item_code' => $assetData['item_code']],
                [
                    'item_id'         => $itemId,
                    'serial_number'   => $assetData['serial'],
                    'purchase_date'   => $assetData['purchase_date'],
                    'purchase_price'  => $assetData['purchase_price'],
                    'warranty_expiry' => date('Y-m-d', strtotime($assetData['purchase_date'] . ' +1 year')),
                    'condition'       => $assetData['condition'],
                    'department_id'   => $deptId,
                    'status'          => $assetData['status'],
                ]
            );

            // Create active assignment if assignee is set and asset doesn't have one yet
            if ($assetData['assignee'] && $asset->wasRecentlyCreated) {
                $employee = $emp($assetData['assignee']);
                if ($employee) {
                    AssetAssignment::create([
                        'asset_id'            => $asset->id,
                        'assignable_type'     => Employee::class,
                        'assignable_id'       => $employee->id,
                        'assigned_by'         => $admin->id,
                        'assigned_at'         => now()->subDays(rand(30, 180)),
                        'condition_on_assign' => 'good',
                        'purpose'             => 'Official work use',
                        'status'              => 'active',
                    ]);
                }
            }
        }
    }
}
