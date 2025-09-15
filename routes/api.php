<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\MenuApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\CategoryApiController;


Route::prefix('v1')->group(function () {
    /**
     * Kategori:
     * GET /categories
     * - Mengambil semua kategori yang tersedia.
     *
     */
    Route::get('/categories', [CategoryApiController::class, 'showCategories']);
    /**
     * Menu:
     * GET /menus
     * - Mengambil semua menu yang tersedia.
     */

    Route::get('/menus', [MenuApiController::class, 'showMenus']);
    /**
     * Pesanan (Prefix: /order):
     * POST /order/checkout
     * - Melakukan checkout dan membuat pesanan baru.
     * GET /order/timeline/{user_id}
     * - Mendapatkan riwayat pesanan untuk pengguna tertentu.
     * GET /order/invoice/{order_number}
     * - Mengunduh invoice untuk pesanan tertentu.
     * GET /order/available
     * - Mendapatkan semua pesanan yang tersedia untuk dikirim.
     * GET /order/my-deliveries/{user_id}
     * - Mendapatkan semua pengantaran yang ditugaskan ke pengguna tertentu.
     * POST /order/assign/{order_number}
     * - Menugaskan pesanan ke kurir.
     * POST /order/complete
     * - Menandai pesanan sebagai selesai.
     */

    Route::prefix('/order')->group(function () {
        Route::post('/checkout', [OrderApiController::class, 'checkoutOrder']);
        Route::get('/timeline/{user_id}', [OrderApiController::class, 'getOrderTimeline']);
        Route::get('/invoice/{order_number}', [OrderApiController::class, 'downloadInvoice']);
        Route::get('/available', [OrderApiController::class, 'getAvailableOrders']);
        Route::get('/my-deliveries/{user_id}', [OrderApiController::class, 'getMyDeliveries']);
        Route::post('/assign/{order_number}', [OrderApiController::class, 'assignOrder']);
        Route::post('/complete', [OrderApiController::class, 'completeOrder']);
    });

    /**
     * Keranjang (Prefix: /cart):
     * GET /cart/user/{user_id}
     * - Mengambil keranjang milik pengguna tertentu.
     * POST /cart/add
     * - Menambahkan item ke keranjang pengguna.
     * PATCH /cart/update/{cart_id}
     * - Memperbarui jumlah item di keranjang.
     * DELETE /cart/delete/{cart_id}
     * - Menghapus item dari keranjang pengguna.
     */
    Route::prefix('/cart')->group(function () {
        Route::get('/user/{user_id}', [CartApiController::class, 'getUserCart']);
        Route::post('/add', [CartApiController::class, 'addToCart']);
        Route::patch('/update/{cart_id}', [CartApiController::class, 'updateQuantity']);
        Route::delete('/delete/{cart_id}', [CartApiController::class, 'removeFromCart']);
    });

});
