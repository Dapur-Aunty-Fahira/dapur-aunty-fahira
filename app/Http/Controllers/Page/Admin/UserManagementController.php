<?php

namespace App\Http\Controllers\Page\Admin;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.user-management');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'phone' => $data['phone'] ?? null,
            ]);

            return $this->success($user, 'Pengguna berhasil ditambahkan', 201);
        } catch (\Throwable $e) {
            Log::error('UserManagementController@store', [
                'exception' => $e,
                'request' => $request->all()
            ]);

            return $this->error('Terjadi kesalahan saat menyimpan data pengguna');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //showing all users with pagination
        try {
            $perPage = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value', '');

            $query = User::query();

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $total = User::count();
            $filtered = $query->count();

            $users = $query->skip($start)->take($perPage)->get();

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $total,
                'recordsFiltered' => $filtered,
                'data' => $users,
            ]);
        } catch (\Exception $e) {
            Log::error('UserManagementController@show', [
                'exception' => $e,
                'request' => $request->all(),
            ]);
            return $this->error('Terjadi kesalahan saat mengambil data pengguna');
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user_id)
    {
        try {
            $user = User::findOrFail($user_id);

            return $this->success($user, 'Data pengguna berhasil diambil');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error('Pengguna tidak ditemukan', 404);
        } catch (\Throwable $e) {
            Log::error('UserManagementController@edit', [
                'exception' => $e,
                'user_id' => $user_id,
            ]);

            return $this->error('Terjadi kesalahan saat mengambil data pengguna');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return $this->error('Pengguna tidak ditemukan', 404);
        }

        // Update user
        // dd($request->all());
        // Validate incoming request
        $data = $request->validated();

        // Update user data
        // Only update password if provided
        try {
            $data = $request->validated();

            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'phone' => $data['phone'] ?? null,
                'password' => isset($data['password']) ? Hash::make($data['password']) : $user->password,
            ]);

            return $this->success($user, 'Pengguna berhasil diperbarui');
        } catch (\Throwable $e) {
            Log::error('UserManagementController@show', [
                'exception' => $e,
                'request' => $request->all()
            ]);

            return $this->error('Terjadi kesalahan saat memperbarui pengguna');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deleted = User::destroy($id);

            if (!$deleted) {
                return $this->error('Pengguna tidak ditemukan atau gagal dihapus', 404);
            }

            return $this->success(null, 'Pengguna berhasil dihapus');
        } catch (\Throwable $e) {
            Log::error('UserManagementController@destroy', [
                'exception' => $e,
                'user_id' => $id,
            ]);

            return $this->error('Terjadi kesalahan saat menghapus pengguna');
        }
    }

}
