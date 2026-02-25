<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\InventoryStock;
use App\Models\Item;
use App\Models\StockIssuance;
use App\Models\User;
use Illuminate\Database\Seeder;

class StockIssuanceSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $dept  = fn (string $code) => Department::where('code', $code)->first();
        $item  = fn (string $name) => Item::where('name', $name)->first();
        $emp   = fn (string $id) => Employee::where('employee_id', $id)->first();

        $issuances = [
            // ── BOD: Clothing to employees ────────────────────────────────
            [
                'item'           => 'Staff T-Shirt',
                'dept_code'      => 'BOD',
                'quantity'       => 5,
                'issued_to_type' => 'employee',
                'issued_to_id'   => 'EMP-004',
                'purpose'        => 'Monthly uniform issuance',
                'reference_no'   => 'ISS-BOD-001',
                'issued_at'      => now()->subDays(30),
            ],
            [
                'item'           => 'Staff Polo Shirt',
                'dept_code'      => 'BOD',
                'quantity'       => 3,
                'issued_to_type' => 'employee',
                'issued_to_id'   => 'EMP-005',
                'purpose'        => 'New employee uniform',
                'reference_no'   => 'ISS-BOD-002',
                'issued_at'      => now()->subDays(20),
            ],

            // ── GOD: Food to department ────────────────────────────────────
            [
                'item'           => 'Chicken Breast',
                'dept_code'      => 'GOD',
                'quantity'       => 10,
                'issued_to_type' => 'department',
                'issued_to_id'   => null,
                'dept_target'    => 'GOD',
                'purpose'        => 'Weekly kitchen supply',
                'reference_no'   => 'ISS-GOD-001',
                'issued_at'      => now()->subDays(7),
            ],
            [
                'item'           => 'White Rice',
                'dept_code'      => 'GOD',
                'quantity'       => 2,
                'issued_to_type' => 'department',
                'issued_to_id'   => null,
                'dept_target'    => 'GOD',
                'purpose'        => 'Bi-weekly rice supply',
                'reference_no'   => 'ISS-GOD-002',
                'issued_at'      => now()->subDays(14),
            ],
            [
                'item'           => 'Cooking Oil',
                'dept_code'      => 'GOD',
                'quantity'       => 5,
                'issued_to_type' => 'department',
                'issued_to_id'   => null,
                'dept_target'    => 'GOD',
                'purpose'        => 'Monthly cooking supply',
                'reference_no'   => 'ISS-GOD-003',
                'issued_at'      => now()->subDays(10),
            ],

            // ── DOD: Bedding to employees ──────────────────────────────────
            [
                'item'           => 'Blanket',
                'dept_code'      => 'DOD',
                'quantity'       => 10,
                'issued_to_type' => 'employee',
                'issued_to_id'   => 'EMP-013',
                'purpose'        => 'New dormitory occupant supplies',
                'reference_no'   => 'ISS-DOD-001',
                'issued_at'      => now()->subDays(15),
            ],
            [
                'item'           => 'Pillow',
                'dept_code'      => 'DOD',
                'quantity'       => 10,
                'issued_to_type' => 'employee',
                'issued_to_id'   => 'EMP-013',
                'purpose'        => 'New dormitory occupant supplies',
                'reference_no'   => 'ISS-DOD-002',
                'issued_at'      => now()->subDays(15),
            ],
            [
                'item'           => 'Bed Sheet Set',
                'dept_code'      => 'DOD',
                'quantity'       => 8,
                'issued_to_type' => 'employee',
                'issued_to_id'   => 'EMP-014',
                'purpose'        => 'Quarterly linen replacement',
                'reference_no'   => 'ISS-DOD-003',
                'issued_at'      => now()->subDays(5),
            ],

            // ── HRAD: Office supplies to employees ────────────────────────
            [
                'item'           => 'Bond Paper (A4)',
                'dept_code'      => 'HRAD',
                'quantity'       => 5,
                'issued_to_type' => 'employee',
                'issued_to_id'   => 'EMP-008',
                'purpose'        => 'Monthly office supplies',
                'reference_no'   => 'ISS-HRAD-001',
                'issued_at'      => now()->subDays(8),
            ],
            [
                'item'           => 'Ballpen',
                'dept_code'      => 'HRAD',
                'quantity'       => 2,
                'issued_to_type' => 'employee',
                'issued_to_id'   => 'EMP-009',
                'purpose'        => 'Monthly writing supplies',
                'reference_no'   => 'ISS-HRAD-002',
                'issued_at'      => now()->subDays(8),
            ],

            // ── PRPD: Office supplies ──────────────────────────────────────
            [
                'item'           => 'Bond Paper (A4)',
                'dept_code'      => 'PRPD',
                'quantity'       => 10,
                'issued_to_type' => 'employee',
                'issued_to_id'   => 'EMP-006',
                'purpose'        => 'Research documentation supplies',
                'reference_no'   => 'ISS-PRPD-001',
                'issued_at'      => now()->subDays(12),
            ],

            // ── FIN: Office supplies ───────────────────────────────────────
            [
                'item'           => 'Bond Paper (A4)',
                'dept_code'      => 'FIN',
                'quantity'       => 5,
                'issued_to_type' => 'employee',
                'issued_to_id'   => 'EMP-015',
                'purpose'        => 'Financial reports printing',
                'reference_no'   => 'ISS-FIN-001',
                'issued_at'      => now()->subDays(3),
            ],
        ];

        foreach ($issuances as $s) {
            $itemModel = $item($s['item']);
            $deptModel = $dept($s['dept_code']);

            if (! $itemModel || ! $deptModel) {
                continue;
            }

            // Determine issuable (morphable)
            if ($s['issued_to_type'] === 'employee' && ! empty($s['issued_to_id'])) {
                $issuable = $emp($s['issued_to_id']);
            } else {
                $targetCode = $s['dept_target'] ?? $s['dept_code'];
                $issuable   = $dept($targetCode);
            }

            if (! $issuable) {
                continue;
            }

            // Check that stock exists before issuing
            $stock = InventoryStock::where('item_id', $itemModel->id)
                ->where('department_id', $deptModel->id)
                ->first();

            if (! $stock || $stock->quantity < $s['quantity']) {
                continue; // Skip if insufficient stock
            }

            // Create issuance
            StockIssuance::create([
                'item_id'            => $itemModel->id,
                'from_department_id' => $deptModel->id,
                'quantity'           => $s['quantity'],
                'issuable_type'      => get_class($issuable),
                'issuable_id'        => $issuable->id,
                'purpose'            => $s['purpose'],
                'issued_by'          => $admin->id,
                'issued_at'          => $s['issued_at'],
            ]);

            // Decrement stock
            $stock->decrement('quantity', $s['quantity']);
        }
    }
}
