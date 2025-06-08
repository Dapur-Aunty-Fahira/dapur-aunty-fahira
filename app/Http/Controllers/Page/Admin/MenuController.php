<?php

namespace App\Http\Controllers\Page\Admin;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function show()
    {
        return view('pages.admin.menu');
    }

    public function getListMenu(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $menus = Menu::with('category')->paginate($perPage);
            return response()->json($menus);
        } catch (\Exception $e) {
            Log::error('Error in getAllMenu: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Failed to retrieve menus'
            ], 500);
        }
    }

    public function getMenu($id)
    {
        try {
            $menu = Menu::find($id);
            return response()->json($menu);
        } catch (\Exception $e) {
            Log::error('Error in getMenu' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Failed to retrieve Menu'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:50',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|integer|exists:categories,id',
                'image' => 'required|image',
                'description' => 'required|string',
                'min_order' => 'required|integer|min:1'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('menus', 'public');
                $validated['image'] = $imagePath;
            }

            $menu = Menu::create($validated);
            if (!$menu) {
                return response()->json([
                    'error' => 'Failed to create Menu'
                ], 500);
            }
            return response()->json($menu);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error in Store Menu: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Failed to store Menu'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:50',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|integer|exists:categories,id',
                'description' => 'sometimes|string',
                'min_order' => 'sometimes|integer|min:1',
                'image' => 'sometimes|image'
            ]);

            $menu = Menu::findOrFail($id);

            // Handle image upload if present
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('menus', 'public');
                $validated['image'] = $imagePath;
            }

            $menu->update($validated);
            $menu->refresh();
            return response()->json($menu);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error in Update Menu' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Failed to update Menu'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $menu->delete();
            return response()->json($menu);
        } catch (\Exception $e) {
            Log::error('Error in Delete Menu' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Failed to delete Menu'
            ], 500);
        }
    }
}
