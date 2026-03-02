<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $user  = $request->user();
        $query = Item::with(['category', 'unit']);

        if (! $user->isSystemAdmin()) {
            $query->where('department_id', $user->department_id);
        }

        if ($request->filled('item_type')) {
            $query->where('item_type', $request->item_type);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('brand', 'like', "%{$request->search}%")
                  ->orWhere('model', 'like', "%{$request->search}%");
            });
        }

        $items = $query->orderBy('name')->get()->map(function ($item) {
            if ($item->isFixedAsset()) {
                $item->total_units     = $item->assets()->count();
                $item->available_units = $item->assets()->where('status', 'available')->count();
                $item->assigned_units  = $item->assets()->where('status', 'assigned')->count();
            } else {
                $item->total_stock = $item->inventoryStocks()->sum('quantity');
            }

            return $item;
        });

        return $this->success($items);
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'category_id'     => 'required|exists:categories,id',
            'unit_id'         => 'required|exists:units,id',
            'item_type'       => 'required|in:fixed_asset,consumable',
            'brand'           => 'nullable|string|max:255',
            'model'           => 'nullable|string|max:255',
            'specifications'  => 'nullable|array',
            'min_stock_level' => 'nullable|numeric|min:0',
            'department_id'   => 'nullable|exists:departments,id',
        ]);

        $validated['department_id']   = $user->isSystemAdmin()
            ? ($validated['department_id'] ?? null)
            : $user->department_id;
        $validated['min_stock_level'] = $validated['min_stock_level'] ?? 0;

        $item = Item::create($validated);
        $item->load(['category', 'unit']);

        return $this->created($item);
    }

    public function show(Item $item): JsonResponse
    {
        $item->load(['category', 'unit']);

        if ($item->isFixedAsset()) {
            $item->load(['assets.department', 'assets.activeAssignment.assignable']);
        } else {
            $item->load(['inventoryStocks.department']);
        }

        return $this->success($item);
    }

    public function update(Request $request, Item $item): JsonResponse
    {
        $validated = $request->validate([
            'name'            => 'sometimes|string|max:255',
            'description'     => 'nullable|string',
            'category_id'     => 'sometimes|exists:categories,id',
            'unit_id'         => 'sometimes|exists:units,id',
            'brand'           => 'nullable|string|max:255',
            'model'           => 'nullable|string|max:255',
            'specifications'  => 'nullable|array',
            'min_stock_level' => 'nullable|numeric|min:0',
        ]);

        // item_type cannot be changed once created to protect data integrity
        if (array_key_exists('min_stock_level', $validated)) {
            $validated['min_stock_level'] = $validated['min_stock_level'] ?? 0;
        }
        $item->update($validated);
        $item->load(['category', 'unit']);

        return $this->success($item, 'Item updated successfully');
    }

    public function destroy(Item $item): JsonResponse
    {
        if ($item->isFixedAsset() && $item->assets()->exists()) {
            return $this->error('Cannot delete item with existing asset records.', 422);
        }

        if ($item->isConsumable() && $item->inventoryStocks()->where('quantity', '>', 0)->exists()) {
            return $this->error('Cannot delete item with existing stock.', 422);
        }

        $item->delete();

        return $this->success(null, 'Item deleted successfully');
    }
}
