<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Traits\ApiResponse;

class MenuApiController extends Controller
{
    use ApiResponse;
    public function showMenus(Request $request): JsonResponse
    {
        try {
            $query = Menu::with('category');

            // Filter berdasarkan kategori slug (jika ada)
            if ($request->filled('category')) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('name', $request->category);
                });
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            }

            // Paginasi
            $menus = $query->orderByDesc('updated_at')->paginate(6); // Bisa diubah jumlah per halaman

            // Format respons
            return response()->json([
                'status' => 'sukses',
                'message' => 'Menu berhasil dimuat',
                'data' => $menus->items(), // Hanya data item untuk looping
                'next_page_url' => $menus->nextPageUrl(), // Untuk deteksi akhir
                'current_page' => $menus->currentPage(),
                'last_page' => $menus->lastPage(),
            ]);

        } catch (ValidationException $e) {
            Log::error('Validation error fetching menus: ' . $e->getMessage());
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            Log::error('Error fetching menus: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server.', 500);
        }
    }
}
