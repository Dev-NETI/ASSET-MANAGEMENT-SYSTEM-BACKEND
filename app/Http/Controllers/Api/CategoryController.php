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

    public function index(): JsonResponse
    {
        $categories = Category::with('parent')
            ->withCount('items')
            ->orderBy('name')
            ->get();

        return $this->success($categories);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'nullable|string|max:20|unique:categories,code',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
        ]);

        $category = Category::create($validated);
        $category->load('parent');

        return $this->created($category);
    }

    public function show(Category $category): JsonResponse
    {
        $category->load(['parent', 'children', 'items.unit']);
        $category->loadCount('items');

        return $this->success($category);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'code'        => 'nullable|string|max:20|unique:categories,code,' . $category->id,
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:categories,id',
        ]);

        // Prevent self-referencing or circular parent
        if (isset($validated['parent_id']) && $validated['parent_id'] == $category->id) {
            return $this->error('A category cannot be its own parent.', 422);
        }

        $category->update($validated);
        $category->load('parent');

        return $this->success($category, 'Category updated successfully');
    }

    public function destroy(Category $category): JsonResponse
    {
        if ($category->items()->exists()) {
            return $this->error('Cannot delete category that has items.', 422);
        }

        if ($category->children()->exists()) {
            return $this->error('Cannot delete category that has sub-categories.', 422);
        }

        $category->delete();

        return $this->success(null, 'Category deleted successfully');
    }
}
