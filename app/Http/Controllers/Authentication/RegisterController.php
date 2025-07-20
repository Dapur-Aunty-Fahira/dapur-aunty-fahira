<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
            'phone' => ['required', 'string', 'max:15'],
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
            ]);

            Auth::login($user);
            DB::commit();

            return redirect()->route('home')->with('success', 'Registrasi berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Register error: ' . $e->getMessage());

            return redirect()->route('showRegistrationForm')->withErrors(['register' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])->withInput();
        }
    }
}
