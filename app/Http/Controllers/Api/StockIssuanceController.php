<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryStock;
use App\Models\Item;
use App\Models\StockIssuance;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockIssuanceController extends Controller
{
    use ApiResponse;

    /**
     * List issuances with filters.
     * Filters: department_id (from_department), item_id, issuable_type (employee|department)
     */
    public function index(Request $request): JsonResponse
    {
        $query = StockIssuance::with([
            'item.unit',
            'fromDepartment',
            'issuable',
            'issuedBy',
        ]);

        if ($request->filled('from_department_id')) {
            $query->where('from_department_id', $request->from_department_id);
        }

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        if ($request->filled('issuable_type')) {
            $map = [
                'employee'   => \App\Models\Employee::class,
                'department' => \App\Models\Department::class,
            ];
            if (isset($map[$request->issuable_type])) {
                $query->where('issuable_type', $map[$request->issuable_type]);
            }
        }

        return $this->success(
            $query->orderByDesc('issued_at')->get()
        );
    }

    public function show(StockIssuance $stockIssuance): JsonResponse
    {
        $stockIssuance->load(['item.unit', 'fromDepartment', 'issuable', 'issuedBy']);

        return $this->success($stockIssuance);
    }

    /**
     * Issue consumable stock from a department to a person or department.
     * Also decrements the InventoryStock.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'item_id'            => 'required|exists:items,id',
            'from_department_id' => 'required|exists:departments,id',
            'issuable_type'      => 'required|in:employee,department',
            'issuable_id'        => 'required|integer',
            'quantity'           => 'required|numeric|min:0.01',
            'issued_at'          => 'nullable|date',
            'purpose'            => 'nullable|string|max:500',
            'notes'              => 'nullable|string',
        ]);

        $item = Item::findOrFail($validated['item_id']);
        if ($item->isFixedAsset()) {
            return $this->error('Fixed assets are assigned individually, not issued as stock.', 422);
        }

        // Resolve the polymorphic model
        $modelMap = [
            'employee'   => \App\Models\Employee::class,
            'department' => \App\Models\Department::class,
        ];
        $modelClass = $modelMap[$validated['issuable_type']];
        if (! $modelClass::find($validated['issuable_id'])) {
            return $this->error(ucfirst($validated['issuable_type']) . ' not found.', 422);
        }

        // Check sufficient stock
        $stock = InventoryStock::where('item_id', $validated['item_id'])
            ->where('department_id', $validated['from_department_id'])
            ->first();

        if (! $stock || $stock->quantity < $validated['quantity']) {
            $available = $stock ? $stock->quantity : 0;
            return $this->error("Insufficient stock. Available: {$available}", 422);
        }

        $issuance = DB::transaction(function () use ($validated, $modelClass, $stock, $request) {
            $stock->decrement('quantity', $validated['quantity']);

            return StockIssuance::create([
                'item_id'            => $validated['item_id'],
                'from_department_id' => $validated['from_department_id'],
                'issuable_type'      => $modelClass,
                'issuable_id'        => $validated['issuable_id'],
                'quantity'           => $validated['quantity'],
                'issued_by'          => $request->user()->id,
                'issued_at'          => $validated['issued_at'] ?? now(),
                'purpose'            => $validated['purpose'] ?? null,
                'notes'              => $validated['notes'] ?? null,
            ]);
        });

        $issuance->load(['item.unit', 'fromDepartment', 'issuable', 'issuedBy']);

        return $this->created($issuance, 'Stock issued successfully');
    }
}
