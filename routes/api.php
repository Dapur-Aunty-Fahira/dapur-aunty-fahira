<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\MenuApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\CategoryApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::get('/categories', [CategoryApiController::class, 'showCategories']);
    Route::get('/menus', [MenuApiController::class, 'showMenus']);
    Route::prefix('/order')->group(function () {
        Route::post('/checkout', [OrderApiController::class, 'checkoutOrder']);
        Route::get('/timeline/{user_id}', [OrderApiController::class, 'getOrderTimeline']);
        Route::get('/invoice/{order_number}', [OrderApiController::class, 'downloadInvoice']);
    });
    // route group cart
    Route::prefix('/cart')->group(function () {
        Route::get('/user/{user_id}', [CartApiController::class, 'getUserCart']);
        Route::post('/add', [CartApiController::class, 'addToCart']);
        Route::patch('/update/{cart_id}', [CartApiController::class, 'updateQuantity']);
        Route::delete('/delete/{cart_id}', [CartApiController::class, 'removeFromCart']);
    });



});
