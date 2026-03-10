<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $user  = $request->user();
        $query = Category::orderBy('name');

        if (! $user->isSystemAdmin()) {
            $query->where('department_id', $user->department_id);
        }

        return $this->success($query->get());
    }

    public function store(Request $request): JsonResponse
    {
        $user   = $request->user();
        $deptId = $user->isSystemAdmin()
            ? ($request->input('department_id') ?: null)
            : $user->department_id;

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $validated['department_id'] = $deptId;

        $category = Category::create($validated);

        return $this->created($category);
    }

    public function show(Category $category): JsonResponse
    {
        $category->load('items.unit');
        $category->loadCount('items');

        return $this->success($category);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return $this->success($category, 'Category updated successfully');
    }

    public function destroy(Category $category): JsonResponse
    {
        if ($category->items()->exists()) {
            return $this->error('Cannot delete category that has items.', 422);
        }

        $category->delete();

        return $this->success(null, 'Category deleted successfully');
    }
}
