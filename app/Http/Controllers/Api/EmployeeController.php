<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = Employee::with('department');

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%")
                  ->orWhere('employee_id', 'like', "%{$request->search}%")
                  ->orWhere('position', 'like', "%{$request->search}%");
            });
        }

        return $this->success($query->orderBy('last_name')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_id'   => 'required|string|max:50|unique:employees,employee_id',
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position'      => 'nullable|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone'         => 'nullable|string|max:50',
            'status'        => 'nullable|in:active,inactive',
        ]);

        $employee = Employee::create($validated);
        $employee->load('department');

        return $this->created($employee);
    }

    public function show(Employee $employee): JsonResponse
    {
        $employee->load([
            'department',
            'activeAssetAssignments.asset.item',
            'stockIssuances.item',
        ]);

        return $this->success($employee);
    }

    public function update(Request $request, Employee $employee): JsonResponse
    {
        $validated = $request->validate([
            'employee_id'   => 'sometimes|string|max:50|unique:employees,employee_id,' . $employee->id,
            'first_name'    => 'sometimes|string|max:255',
            'last_name'     => 'sometimes|string|max:255',
            'department_id' => 'sometimes|exists:departments,id',
            'position'      => 'nullable|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone'         => 'nullable|string|max:50',
            'status'        => 'nullable|in:active,inactive',
        ]);

        $employee->update($validated);
        $employee->load('department');

        return $this->success($employee, 'Employee updated successfully');
    }

    public function destroy(Employee $employee): JsonResponse
    {
        if ($employee->activeAssetAssignments()->exists()) {
            return $this->error('Cannot delete employee with active asset assignments.', 422);
        }

        $employee->delete();

        return $this->success(null, 'Employee deleted successfully');
    }
}
