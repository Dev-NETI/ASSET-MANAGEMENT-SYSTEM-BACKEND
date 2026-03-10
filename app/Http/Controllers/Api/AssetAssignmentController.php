<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssetAssignment;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetAssignmentController extends Controller
{
    use ApiResponse;

    /**
     * List assignments with filters.
     * Filters: status, department_id (asset's department), assignable_type (employee|department)
     */
    public function index(Request $request): JsonResponse
    {
        $user  = $request->user();
        $query = AssetAssignment::with([
            'asset.item.category',
            'asset.department',
            'assignable',
            'assignedBy',
            'returnedBy',
        ]);

        if (! $user->isSystemAdmin()) {
            $query->whereHas('asset', fn ($q) => $q->where('department_id', $user->department_id));
        } else {
            if ($request->filled('department_id')) {
                $query->whereHas('asset', fn ($q) => $q->where('department_id', $request->department_id));
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('assignable_type')) {
            $map = [
                'employee'   => \App\Models\Employee::class,
                'department' => \App\Models\Department::class,
            ];
            if (isset($map[$request->assignable_type])) {
                $query->where('assignable_type', $map[$request->assignable_type]);
            }
        }

        if ($request->filled('assignable_id')) {
            $query->where('assignable_id', $request->assignable_id);
        }

        return $this->success(
            $query->orderByDesc('assigned_at')->get()
        );
    }

    public function show(AssetAssignment $assetAssignment): JsonResponse
    {
        $assetAssignment->load([
            'asset.item.category',
            'asset.item.unit',
            'asset.department',
            'assignable',
            'assignedBy',
            'returnedBy',
        ]);

        return $this->success($assetAssignment);
    }

    public function update(Request $request, AssetAssignment $assetAssignment): JsonResponse
    {
        $validated = $request->validate([
            'expected_return_date' => 'nullable|date',
            'purpose'              => 'nullable|string|max:500',
            'notes'                => 'nullable|string',
            'status'               => 'nullable|in:active,returned',
        ]);

        $assetAssignment->update($validated);

        return $this->success($assetAssignment, 'Assignment updated successfully');
    }

    public function destroy(AssetAssignment $assetAssignment): JsonResponse
    {
        if ($assetAssignment->status === 'active') {
            return $this->error('Cannot delete an active assignment. Return the asset first.', 422);
        }

        $assetAssignment->delete();

        return $this->success(null, 'Assignment record deleted');
    }
}
