<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class CartApiController extends Controller
{
    use ApiResponse;
    /**
     * Mengelola operasi API terkait keranjang belanja untuk pengguna.
     *
     * Metode:
     *
     * getUserCart($userId)
     *   Mengambil semua item keranjang untuk pengguna tertentu, termasuk detail menu terkait.
     *   Mengembalikan respons sukses dengan item keranjang atau respons error jika gagal.
     *
     * addToCart(Request $request)
     *   Menambahkan item menu ke keranjang pengguna atau memperbarui jumlah jika sudah ada.
     *   Memvalidasi permintaan untuk user_id, menu_id, dan quantity.
     *   Mengembalikan respons sukses dengan item keranjang atau respons error jika gagal.
     *
     * updateQuantity(Request $request, $cartId)
     *   Memperbarui jumlah item pada keranjang tertentu.
     *   Memvalidasi permintaan untuk quantity.
     *   Mengembalikan respons sukses dengan item keranjang yang diperbarui atau respons error jika gagal.
     *
     * removeFromCart($cartId)
     *   Menghapus item tertentu dari keranjang.
     *   Mengembalikan respons sukses jika berhasil dihapus atau respons error jika gagal.
     *
     * Penanganan Error:
     *   Menangkap exception validasi dan umum, mencatat error, dan mengembalikan respons error yang sesuai.
     */

    /**
     * Mengambil semua item keranjang untuk pengguna tertentu.
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserCart($userId)
    {
        try {
            $cartItems = Cart::with('menu')->ofUser($userId)->orderBy('created_at', 'desc')->get()->map(fn($item) => [
                'cart_id' => $item->cart_id,
                'menu_id' => $item->menu_id,
                'name' => $item->menu->name,
                'price' => $item->menu->price,
                'quantity' => $item->quantity,
                'total_price' => $item->total_price,
            ]);

            return $this->success($cartItems, 'Keranjang berhasil dimuat');

        } catch (ValidationException $e) {
            Log::error('Validation error fetching cart: ' . $e->getMessage());
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            Log::error('Error fetching cart: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server.', 500);
        }
    }

    /**
     * Menambahkan item ke keranjang pengguna atau memperbarui jumlah jika sudah ada.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'menu_id' => 'required|exists:menus,menu_id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cartItem = Cart::where('user_id', $validated['user_id'])
                ->where('menu_id', $validated['menu_id'])
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $validated['quantity'];
                $cartItem->save();
            } else {
                $cartItem = Cart::create([
                    'user_id' => $validated['user_id'],
                    'menu_id' => $validated['menu_id'],
                    'quantity' => $validated['quantity'],
                ]);
            }

            return $this->success($cartItem, 'Item berhasil ditambahkan ke keranjang');

        } catch (ValidationException $e) {
            Log::error('Validation error adding to cart: ' . $e->getMessage());
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server.', 500);
        }
    }

    /**
     * Memperbarui jumlah item pada keranjang tertentu.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $cartId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQuantity(Request $request, $cartId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cartItem = Cart::findOrFail($cartId);
            $cartItem->update(['quantity' => $validated['quantity']]);

            return $this->success($cartItem, 'Jumlah item berhasil diperbarui');

        } catch (ValidationException $e) {
            Log::error('Validation error updating cart: ' . $e->getMessage());
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            Log::error('Error updating cart: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server.', 500);
        }
    }

    /**
     * Menghapus item tertentu dari keranjang.
     *
     * @param int $cartId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFromCart($cartId)
    {
        try {
            $cartItem = Cart::findOrFail($cartId);
            $cartItem->delete();

            return $this->success(null, 'Item berhasil dihapus dari keranjang');

        } catch (ValidationException $e) {
            Log::error('Validation error removing from cart: ' . $e->getMessage());
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            Log::error('Error removing from cart: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server.', 500);
        }
    }
}
