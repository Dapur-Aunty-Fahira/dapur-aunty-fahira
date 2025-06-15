<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\Login;
use App\Http\Controllers\Authentication\Register;
use App\Http\Controllers\Page\Admin\AdminDashboard;
use App\Http\Controllers\Page\Admin\MenuController;
use App\Http\Controllers\Page\Guest\GuestDashboard;
use App\Http\Controllers\Page\Admin\CategoryController;
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
        'pelanggan' => redirect()->route('guest.dashboard'),
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
});

// Pelanggan-only routes
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('guest/dashboard', [GuestDashboard::class, 'show'])->name('guest.dashboard');
});
