<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $user  = $request->user();
        $query = Supplier::withCount('stockReceivials')->orderBy('name');

        if (! $user->isSystemAdmin()) {
            $query->where('department_id', $user->department_id);
        }

        return $this->success($query->get());
    }

    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'address'        => 'nullable|string',
            'department_id'  => 'nullable|exists:departments,id',
        ]);

        $validated['department_id'] = $user->isSystemAdmin()
            ? ($validated['department_id'] ?? null)
            : $user->department_id;

        return $this->created(Supplier::create($validated));
    }

    public function show(Supplier $supplier): JsonResponse
    {
        $supplier->load('stockReceivials.item');
        $supplier->loadCount('stockReceivials');

        return $this->success($supplier);
    }

    public function update(Request $request, Supplier $supplier): JsonResponse
    {
        $validated = $request->validate([
            'name'           => 'sometimes|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'address'        => 'nullable|string',
        ]);

        $supplier->update($validated);

        return $this->success($supplier, 'Supplier updated successfully');
    }

    public function destroy(Supplier $supplier): JsonResponse
    {
        $supplier->delete();

        return $this->success(null, 'Supplier deleted successfully');
    }
}
