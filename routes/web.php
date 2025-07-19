<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\Login;
use App\Http\Controllers\Authentication\Register;
use App\Http\Controllers\Page\Admin\AdminDashboard;
use App\Http\Controllers\Page\Admin\MenuController;
use App\Http\Controllers\Page\Admin\OrderController;
use App\Http\Controllers\Page\Admin\ReportController;
use App\Http\Controllers\Page\Admin\CategoryController;
use App\Http\Controllers\Page\Guest\CheckoutController;
use App\Http\Controllers\Page\Kurir\DeliveryController;
use App\Http\Controllers\Page\Guest\OrderCustomerController;
use App\Http\Controllers\Page\Admin\UserManagementController;
use App\Http\Controllers\Authentication\ChangePasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// root
Route::get('/', function () {
    if (!Auth::check()) {
        return view('landing');
    }

    $user = Auth::user();
    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'pelanggan' => redirect()->route('guest.pemesanan'),
        'kurir' => redirect()->route('kurir.delivery.index'),
        default => redirect()->route('showLogin'),
    };
})->name('home');


// Authentication
Route::get('login', [Login::class, 'showLoginForm'])->name('showLogin');
Route::post('login', [Login::class, 'login'])->name('login');
Route::get('/register', [Register::class, 'showRegistrationForm'])->name('showRegister');
Route::post('/register', [Register::class, 'register'])->name('register');
Route::post('logout', function () {
    Auth::logout();
    return redirect()->route('showLogin');
})->name('logout');

Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])
    ->middleware('auth')
    ->name('password.change');


// Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {

    // dashboard
    Route::get('admin/dashboard', [AdminDashboard::class, 'show'])->name('admin.dashboard');
    Route::get('admin/stats/users-orders', [AdminDashboard::class, 'getUserOrderStats'])->name('admin.dashboard.orders');

    // category
    Route::prefix('admin/category')->group(function () {
        Route::get('all', [CategoryController::class, 'getAllCategory'])->name('admin.category.all');
        Route::get('{id}', [CategoryController::class, 'getCategory'])->name('admin.category');
        Route::post('store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::put('update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    });

    // menu
    Route::prefix('admin/menu')->group(function () {
        Route::get('', [MenuController::class, 'show'])->name('admin.menu');
        Route::get('list', [MenuController::class, 'getListMenu'])->name('admin.menu.list');
        Route::get('{id}', [MenuController::class, 'getMenu'])->name('admin.menu ');
        Route::post('store', [MenuController::class, 'store'])->name('admin.menu.store');
        Route::put('update/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
        Route::delete('destroy/{id}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
    });

    // users
    Route::prefix('admin/users')->group(function () {
        Route::get('', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('show', [UserManagementController::class, 'show'])->name('admin.users.show');
        Route::post('store', [UserManagementController::class, 'store'])->name('admin.users.store');
        Route::get('{user}', [UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::put('{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
        Route::delete('{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
    });

    // order
    Route::prefix('admin/orders')->group(function () {
        Route::get('', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/show', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('{order_number}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    });

    // laporan
    Route::prefix('admin/reports')->group(function () {
        Route::get('', [ReportController::class, 'index'])->name('admin.report.index');
        Route::get('show', [ReportController::class, 'show'])->name('admin.report.show');
    });
});

// Kurir-only routes
Route::middleware(['auth', 'role:kurir'])->group(function () {
    // pengiriman
    Route::prefix('kurir/delivery')->group(function () {
        Route::get('', [DeliveryController::class, 'index'])->name('kurir.delivery.index');
    });
});



// Pelanggan-only routes
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('pemesanan', [OrderCustomerController::class, 'index'])->name('guest.pemesanan');
    Route::get('checkout', [CheckoutController::class, 'index'])->name('guest.checkout');
});
