<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        return $this->success(Unit::withCount('items')->orderBy('name')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'abbreviation' => 'required|string|max:20',
        ]);

        return $this->created(Unit::create($validated));
    }

    public function show(Unit $unit): JsonResponse
    {
        $unit->loadCount('items');

        return $this->success($unit);
    }

    public function update(Request $request, Unit $unit): JsonResponse
    {
        $validated = $request->validate([
            'name'         => 'sometimes|string|max:255',
            'abbreviation' => 'sometimes|string|max:20',
        ]);

        $unit->update($validated);

        return $this->success($unit, 'Unit updated successfully');
    }

    public function destroy(Unit $unit): JsonResponse
    {
        if ($unit->items()->exists()) {
            return $this->error('Cannot delete unit that is used by items.', 422);
        }

        $unit->delete();

        return $this->success(null, 'Unit deleted successfully');
    }
}
