<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class OrderApiController extends Controller
{
    use ApiResponse;
    public function checkoutOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'delivery_date' => 'required|date',
            'delivery_time' => 'required|string',
            'address' => 'required',
            'notes' => 'nullable|string',
            'payment_proof' => 'required|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $userId = $validated['user_id'];
            // Ambil item cart user
            $cartItems = Cart::with('menu')->ofUser($userId)->get();
            if ($cartItems->isEmpty()) {
                return response()->json(['status' => 'gagal', 'message' => 'Keranjang kosong.'], 400);
            }
            // Hitung total
            $total = $cartItems->sum(function ($item) {
                if (!$item->menu) {
                    throw new \Exception('Menu tidak ditemukan untuk salah satu item di keranjang.');
                }
                return $item->quantity * $item->menu->price;
            });
            // Simpan bukti bayar
            $buktiPath = $request->file('payment_proof')->store('bukti-bayar', 'public');
            // Buat nomor order
            $orderNumber = 'ORD-' . strtoupper(Str::random(8));

            // Buat Order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $userId,
                'address' => $validated['address'],
                'delivery_date' => $validated['delivery_date'],
                'delivery_time' => $validated['delivery_time'],
                'notes' => $validated['notes'] ?? null,
                'total_price' => $total,
                'payment_proof' => $buktiPath,
            ]);

            // Buat OrderItem
            foreach ($cartItems as $item) {
                if (!$item->menu) {
                    throw new \Exception('Menu tidak ditemukan untuk salah satu item di keranjang.');
                }
                OrderItem::create([
                    'order_number' => $order->order_number,
                    'menu_id' => $item->menu_id,
                    'quantity' => $item->quantity,
                    'price' => $item->menu->price,
                    'notes' => null,
                ]);
            }

            // Hapus cart
            Cart::ofUser($userId)->delete();


            DB::commit();
            return $this->success([
                'order_number' => $order->order_number,
                'total_price' => $order->total_price,
                'payment_proof' => $order->payment_proof,
                'delivery_date' => $order->delivery_date,
                'delivery_time' => $order->delivery_time,
            ], 'Order berhasil dibuat');

        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error during order checkout: ' . $e->getMessage());
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error for debugging
            Log::error('Error during order checkout: ' . $e->getMessage());
            return $this->error(null, 'Gagal membuat pesanan', 500);
        }
    }
}
