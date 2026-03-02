<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssetAssignment;
use App\Models\ItemAsset;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemAssetController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $user  = $request->user();
        $query = ItemAsset::with(['item.category', 'department', 'activeAssignment.assignable']);

        if (! $user->isSystemAdmin()) {
            $query->where('department_id', $user->department_id);
        } elseif ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('item_code', 'like', "%{$request->search}%")
                    ->orWhere('serial_number', 'like', "%{$request->search}%");
            });
        }

        return $this->success($query->orderBy('item_code')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'item_id'         => 'required|exists:items,id',
            'item_code'       => 'required|string|max:100|unique:item_assets,item_code',
            'serial_number'   => 'nullable|string|max:255',
            'purchase_date'   => 'nullable|date',
            'purchase_price'  => 'nullable|numeric|min:0',
            'warranty_expiry' => 'nullable|date|after_or_equal:purchase_date',
            'condition'       => 'nullable|in:new,good,fair,poor,damaged,lost,disposed',
            'department_id'   => $user->isSystemAdmin() ? 'required|exists:departments,id' : 'nullable|exists:departments,id',
            'status'               => 'nullable|in:available,assigned,under_repair,disposed',
            'notes'                => 'nullable|string',
            'delivery_receipt_no'  => 'nullable|string|max:255',
        ]);

        // Employee users are scoped to their own department
        if (! $user->isSystemAdmin()) {
            $validated['department_id'] = $user->department_id;
        }

        // Ensure item is a fixed_asset type
        $item = \App\Models\Item::findOrFail($validated['item_id']);
        if ($item->isConsumable()) {
            return $this->error('Cannot register an asset for a consumable item. Use stock receivals instead.', 422);
        }

        $asset = ItemAsset::create($validated);
        $asset->load(['item.category', 'department']);

        return $this->created($asset);
    }

    /**
     * Public lookup by item_code — no auth required.
     * GET /api/item-assets/code/{code}
     */
    public function showByCode(string $code): JsonResponse
    {
        $asset = ItemAsset::with([
            'item.category',
            'department',
            'activeAssignment.assignable',
        ])->where('item_code', $code)->first();

        if (! $asset) {
            return $this->error('Asset not found.', 404);
        }

        return $this->success($asset);
    }

    public function show(ItemAsset $itemAsset): JsonResponse
    {
        $itemAsset->load([
            'item.category',
            'item.unit',
            'department',
            'activeAssignment.assignable',
            'assignments' => fn($q) => $q->with(['assignable', 'assignedBy', 'returnedBy'])->latest('assigned_at'),
        ]);

        return $this->success($itemAsset);
    }

    public function update(Request $request, ItemAsset $itemAsset): JsonResponse
    {
        $validated = $request->validate([
            'serial_number'   => 'nullable|string|max:255',
            'purchase_date'   => 'nullable|date',
            'purchase_price'  => 'nullable|numeric|min:0',
            'warranty_expiry' => 'nullable|date',
            'condition'            => 'nullable|in:new,good,fair,poor,damaged,lost,disposed',
            'department_id'        => 'sometimes|exists:departments,id',
            'status'               => 'nullable|in:available,assigned,under_repair,disposed',
            'notes'                => 'nullable|string',
            'delivery_receipt_no'  => 'nullable|string|max:255',
        ]);

        $itemAsset->update($validated);
        $itemAsset->load(['item.category', 'department', 'activeAssignment.assignable']);

        return $this->success($itemAsset, 'Asset updated successfully');
    }

    /**
     * Upload or replace the delivery receipt file.
     * POST /api/item-assets/{itemAsset}/upload-dr
     */
    public function uploadDeliveryReceipt(Request $request, ItemAsset $itemAsset): JsonResponse
    {
        $request->validate([
            'delivery_receipt_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        // Delete old file if one exists
        if ($itemAsset->delivery_receipt_file) {
            Storage::disk('public')->delete($itemAsset->delivery_receipt_file);
        }

        $path = $request->file('delivery_receipt_file')->store('delivery_receipts', 'public');
        $itemAsset->update(['delivery_receipt_file' => $path]);

        return $this->success($itemAsset, 'Delivery receipt uploaded.');
    }

    public function destroy(ItemAsset $itemAsset): JsonResponse
    {
        if ($itemAsset->activeAssignment()->exists()) {
            return $this->error('Cannot delete an asset that is currently assigned.', 422);
        }

        $itemAsset->delete();

        return $this->success(null, 'Asset deleted successfully');
    }

    /**
     * Assign this asset to an employee or department.
     * POST /api/item-assets/{itemAsset}/assign
     */
    public function assign(Request $request, ItemAsset $itemAsset): JsonResponse
    {
        if ($itemAsset->status === 'assigned') {
            return $this->error('Asset is already assigned. Return it first.', 422);
        }

        if (in_array($itemAsset->status, ['disposed', 'under_repair'])) {
            return $this->error("Asset cannot be assigned while its status is '{$itemAsset->status}'.", 422);
        }

        $validated = $request->validate([
            'assignable_type'      => 'required|in:employee,department,others',
            'assignable_id'        => 'required_unless:assignable_type,others|nullable|integer',
            'assignable_label'     => 'required_if:assignable_type,others|nullable|string|max:500',
            'assigned_at'          => 'nullable|date',
            'expected_return_date' => 'nullable|date',
            'condition_on_assign'  => 'nullable|in:new,good,fair,poor',
            'purpose'              => 'nullable|string|max:500',
            'notes'                => 'nullable|string',
        ]);

        // Resolve the polymorphic model (skip for 'others')
        $modelMap = [
            'employee'   => \App\Models\Employee::class,
            'department' => \App\Models\Department::class,
        ];

        $modelClass = null;
        if ($validated['assignable_type'] !== 'others') {
            $modelClass = $modelMap[$validated['assignable_type']];
            if (! $modelClass::find($validated['assignable_id'])) {
                return $this->error(ucfirst($validated['assignable_type']) . ' not found.', 422);
            }
        }

        DB::transaction(function () use ($itemAsset, $validated, $modelClass, $request) {
            AssetAssignment::create([
                'asset_id'             => $itemAsset->id,
                'assignable_type'      => $modelClass,
                'assignable_id'        => $validated['assignable_id'] ?? null,
                'assignable_label'     => $validated['assignable_label'] ?? null,
                'assigned_by'          => $request->user()->id,
                'assigned_at'          => $validated['assigned_at'] ?? now(),
                'expected_return_date' => $validated['expected_return_date'] ?? null,
                'condition_on_assign'  => $validated['condition_on_assign'] ?? 'good',
                'purpose'              => $validated['purpose'] ?? null,
                'notes'                => $validated['notes'] ?? null,
                'status'               => 'active',
            ]);

            $itemAsset->update(['status' => 'assigned']);
        });

        $itemAsset->load(['item', 'department', 'activeAssignment.assignable']);

        return $this->success($itemAsset, 'Asset assigned successfully');
    }

    /**
     * Return an assigned asset.
     * POST /api/item-assets/{itemAsset}/return
     */
    public function returnAsset(Request $request, ItemAsset $itemAsset): JsonResponse
    {
        $assignment = $itemAsset->activeAssignment;

        if (! $assignment) {
            return $this->error('Asset has no active assignment to return.', 422);
        }

        $validated = $request->validate([
            'condition_on_return' => 'nullable|in:new,good,fair,poor,damaged,lost',
            'notes'               => 'nullable|string',
        ]);

        DB::transaction(function () use ($assignment, $itemAsset, $validated, $request) {
            $returnCondition = $validated['condition_on_return'] ?? 'good';

            $assignment->update([
                'returned_at'          => now(),
                'returned_by'          => $request->user()->id,
                'condition_on_return'  => $returnCondition,
                'notes'                => $validated['notes'] ?? $assignment->notes,
                'status'               => 'returned',
            ]);

            $newCondition = in_array($returnCondition, ['damaged', 'lost'])
                ? $returnCondition
                : $returnCondition;

            $itemAsset->update([
                'status'    => 'available',
                'condition' => $newCondition,
            ]);
        });

        $itemAsset->load(['item', 'department', 'assignments' => fn($q) => $q->latest()->first()]);

        return $this->success($itemAsset, 'Asset returned successfully');
    }
}
