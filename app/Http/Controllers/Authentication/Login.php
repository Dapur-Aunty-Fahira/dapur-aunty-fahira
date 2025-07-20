<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // ✅ 1. Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // ✅ 2. Get the credentials
        $credentials = $request->only('email', 'password');

        // ✅ 3. Attempt login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            // ✅ 4. Role-based redirect
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'pelanggan' => redirect()->route('guest.pemesanan'),
                'kurir' => redirect()->route('kurir.delivery.index'),
                default => $this->logoutWithError('Unknown role'),
            };
        }

        // ✅ 5. Failed login response
        return back()->with('error', 'Invalid credentials')->withInput();
    }

    private function logoutWithError($message)
    {
        Auth::logout();
        return redirect()->route('showLogin')->with('error', $message);
    }
}
