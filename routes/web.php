<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\Login;
use App\Http\Controllers\Authentication\Register;
use App\Http\Controllers\Page\Admin\AdminDashboard;
use App\Http\Controllers\Page\Guest\GuestDashboard;

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
        return view('company-profile');
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
    \Illuminate\Support\Facades\Auth::logout();
    return redirect()->route('showLogin');
})->name('logout');

// Admin-only routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminDashboard::class, 'show'])->name('admin.dashboard');
});

// Pelanggan-only routes
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('guest/dashboard', [GuestDashboard::class, 'show'])->name('guest.dashboard');
});
