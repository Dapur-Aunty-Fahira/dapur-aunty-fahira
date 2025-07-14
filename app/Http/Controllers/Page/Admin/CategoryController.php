<?php

namespace App\Http\Controllers\Page\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function getAllCategory()
    {
        try {
            $categories = Category::orderBy('updated_at', 'desc')->get();
            return response()->json($categories);
        } catch (\Exception $e) {
            Log::error('Error in getAllCategory: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Failed to retrieve categories'
            ], 500);
        }
    }

    public function getCategory($id)
    {
        try {
            $category = Category::find($id);
            return response()->json($category);
        } catch (\Exception $e) {
            Log::error('Error in getCategory' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Failed to retrieve category'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:20|unique:categories,name',
                'description' => 'nullable|string|max:255'
            ]);
            $category = Category::create($validated);
            return response()->json($category);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error in Store Category' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Failed to store category'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:20|unique:categories,name,' . $id,
                'description' => 'nullable|string|max:255'
            ]);
            $category = Category::findOrFail($id);
            $category->update($validated);
            return response()->json($category);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error in Update Category' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Failed to update category'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrfail($id);
            $category->delete();
            return response()->json($category);
        } catch (\Exception $e) {
            Log::error('Error in Delete Category' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Failed to delete category'
            ], 500);
        }
    }
}
