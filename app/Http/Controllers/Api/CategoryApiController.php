<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Traits\ApiResponse;

class CategoryApiController extends Controller
{
    use ApiResponse;
    /**
     * Menampilkan daftar kategori beserta menu yang terkait.
     *
     * Mengambil semua data kategori beserta relasi menu dari database.
     * Mengembalikan respons JSON dengan data kategori jika berhasil.
     * Menangani validasi dan exception umum, mencatat error dan mengembalikan respons yang sesuai.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showCategories(Request $request): JsonResponse
    {
        try {
            $categories = Category::with('menus')->get();
            return $this->success($categories, 'Kategori berhasil dimuat');
        } catch (ValidationException $e) {
            Log::error('Validation error fetching categories: ' . $e->getMessage());
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server.', 500);
        }
    }
}
