<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryStock;
use App\Models\Item;
use App\Models\StockReceival;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockReceivalController extends Controller
{
    use ApiResponse;

    /**
     * List receivals with filters.
     * Filters: department_id, item_id, supplier_id
     */
    public function index(Request $request): JsonResponse
    {
        $user  = $request->user();
        $query = StockReceival::with(['item.unit', 'department', 'supplier', 'receivedBy']);

        if (! $user->isSystemAdmin()) {
            $query->where('department_id', $user->department_id);
        } elseif ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        return $this->success(
            $query->orderByDesc('received_at')->get()
        );
    }

    public function show(StockReceival $stockReceival): JsonResponse
    {
        $stockReceival->load(['item.unit', 'department', 'supplier', 'receivedBy']);

        return $this->success($stockReceival);
    }

    /**
     * Receive new consumable stock into a department.
     * Also increments the InventoryStock.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'item_id'       => 'required|exists:items,id',
            'department_id' => $user->isSystemAdmin() ? 'required|exists:departments,id' : 'nullable|exists:departments,id',
            'quantity'      => 'required|numeric|min:0.01',
            'unit_cost'     => 'nullable|numeric|min:0',
            'supplier_id'   => 'nullable|exists:suppliers,id',
            'reference_no'  => 'nullable|string|max:100',
            'received_at'   => 'nullable|date',
            'notes'         => 'nullable|string',
        ]);

        if (! $user->isSystemAdmin()) {
            $validated['department_id'] = $user->department_id;
        }

        $item = Item::findOrFail($validated['item_id']);
        if ($item->isFixedAsset()) {
            return $this->error('Fixed assets are registered individually via item-assets, not as stock receivals.', 422);
        }

        $receival = DB::transaction(function () use ($validated, $request) {
            // Upsert inventory stock
            $stock = InventoryStock::firstOrCreate(
                ['item_id' => $validated['item_id'], 'department_id' => $validated['department_id']],
                ['quantity' => 0]
            );
            $stock->increment('quantity', $validated['quantity']);

            return StockReceival::create([
                'item_id'       => $validated['item_id'],
                'department_id' => $validated['department_id'],
                'quantity'      => $validated['quantity'],
                'unit_cost'     => $validated['unit_cost'] ?? null,
                'supplier_id'   => $validated['supplier_id'] ?? null,
                'reference_no'  => $validated['reference_no'] ?? null,
                'received_by'   => $request->user()->id,
                'received_at'   => $validated['received_at'] ?? now(),
                'notes'         => $validated['notes'] ?? null,
            ]);
        });

        $receival->load(['item.unit', 'department', 'supplier', 'receivedBy']);

        return $this->created($receival, 'Stock received successfully');
    }
}
