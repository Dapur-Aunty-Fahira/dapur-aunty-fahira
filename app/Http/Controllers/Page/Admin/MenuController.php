<?php

namespace App\Http\Controllers\Page\Admin;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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
            $search = $request->get('search');

            $menus = Menu::with('category')
                ->when($search, function ($query, $search) {
                    $query->where('name', 'ILIKE', "%$search%");
                })
                ->orderBy('updated_at', 'desc')
                ->paginate($perPage);

            return response()->json($menus);
        } catch (\Exception $e) {
            Log::error('Error in getListMenu: ' . $e->getMessage(), [
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
            $menu = Menu::with('category')->findOrFail($id);
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
                'category_id' => 'required|exists:categories,category_id',
                'image' => 'required|image|mimes:jpg,jpeg,png',
                'description' => 'nullable|string',
                'min_order' => 'required|integer|min:1',
                'is_available' => 'boolean',
                'is_popular' => 'boolean',
                'is_new' => 'boolean',
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('menus', 'public');
            }

            $menu = Menu::create($validated);
            return response()->json($menu, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validasi gagal',
                'messages' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error in Store Menu: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Gagal menyimpan menu'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $menu = Menu::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:50',
                'price' => 'required|numeric|min:0',
                'category_id' => 'required|exists:categories,category_id',
                'description' => 'nullable|string',
                'min_order' => 'required|integer|min:1',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'is_available' => 'boolean',
                'is_popular' => 'boolean',
                'is_new' => 'boolean',
            ]);

            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                    Storage::disk('public')->delete($menu->image);
                }
                $validated['image'] = $request->file('image')->store('menus', 'public');
            }

            $menu->update($validated);
            return response()->json($menu);
        } catch (ValidationException $e) {
            Log::error('Validation error in Update Menu: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Validasi gagal',
                'messages' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error in Update Menu' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Gagal memperbarui menu'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $menu->delete();
            return response()->json(['message' => 'Menu berhasil dihapus']);
        } catch (\Exception $e) {
            Log::error('Error in destroy Menu: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Gagal menghapus menu'], 500);
        }
    }
}
