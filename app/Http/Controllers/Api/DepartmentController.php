<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $departments = Department::withCount(['employees', 'itemAssets', 'inventoryStocks'])
            ->orderBy('name')
            ->get();

        return $this->success($departments);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'code'      => 'required|string|max:20|unique:departments,code',
            'description' => 'nullable|string',
            'head_name' => 'nullable|string|max:255',
        ]);

        $department = Department::create($validated);

        return $this->created($department);
    }

    public function show(Department $department): JsonResponse
    {
        $department->load([
            'employees' => fn ($q) => $q->where('status', 'active')->orderBy('last_name'),
            'itemAssets.item',
            'inventoryStocks.item.unit',
        ]);
        $department->loadCount(['employees', 'itemAssets']);

        return $this->success($department);
    }

    public function update(Request $request, Department $department): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'code'        => 'sometimes|string|max:20|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'head_name'   => 'nullable|string|max:255',
        ]);

        $department->update($validated);

        return $this->success($department, 'Department updated successfully');
    }

    public function destroy(Department $department): JsonResponse
    {
        if ($department->employees()->exists()) {
            return $this->error('Cannot delete department with active employees.', 422);
        }

        if ($department->itemAssets()->exists()) {
            return $this->error('Cannot delete department with assigned assets.', 422);
        }

        $department->delete();

        return $this->success(null, 'Department deleted successfully');
    }
}
