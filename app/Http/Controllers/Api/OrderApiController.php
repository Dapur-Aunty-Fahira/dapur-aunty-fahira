<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Order;
use PDF;
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

    public function getOrderTimeline($userId): JsonResponse
    {
        try {
            $orders = Order::with(['items.menu'])
                ->where('user_id', $userId)
                ->orderByDesc('created_at')
                ->get()
                ->map(function ($order) {
                    return [
                        'order_number' => $order->order_number,
                        'total_price' => $order->total_price,
                        'order_status' => $order->order_status,
                        'delivery_date' => $order->delivery_date,
                        'delivery_time' => $order->delivery_time,
                        'address' => $order->address,
                        'created_at' => $order->created_at->format('d M Y H:i'),
                        'items' => $order->items->map(function ($item) {
                            return [
                                'menu_name' => $item->menu->name ?? 'Menu tidak ditemukan',
                                'price' => $item->price,
                                'quantity' => $item->quantity
                            ];
                        })
                    ];
                });
            return $this->success($orders, 'Timeline pesanan berhasil dimuat');
        } catch (ValidationException $e) {
            Log::error('Validation error fetching order timeline: ' . $e->getMessage());
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            Log::error('Error fetching order timeline: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server.', 500);
        }
    }

    public function downloadInvoice(Request $request, $orderNumber, PDF $pdf)
    {
        try {
            $order = Order::with(['items.menu'])
                ->where('order_number', $orderNumber)
                ->firstOrFail();

            $pdf = PDF::loadView('invoice.order', compact('order'));

            return $pdf->download("Invoice_{$order->order_number}.pdf");
        } catch (\Exception $e) {
            Log::error('Error generating invoice: ' . $e->getMessage());
            return $this->error('Gagal mengunduh invoice.', 500);
        }
    }

    public function getAvailableOrders(): JsonResponse
    {
        try {
            $orders = Order::with(['items.menu'])
                ->where('order_status', 'dikirim')
                ->whereNull('courier_id')
                ->orderByDesc('delivery_date')
                ->get()
                ->map(function ($order) {
                    return [
                        'order_number' => $order->order_number,
                        'total_price' => $order->total_price,
                        'address' => $order->address,
                        'delivery_date' => $order->delivery_date,
                        'delivery_time' => $order->delivery_time,
                        'created_at' => $order->created_at->format('d M Y H:i'),
                    ];
                });
            return $this->success($orders, 'Daftar pesanan tersedia berhasil dimuat');
        } catch (\Exception $e) {
            Log::error('Error fetching available orders: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server.', 500);
        }
    }

    public function getMyDeliveries($userId): JsonResponse
    {
        try {
            $orders = Order::with(['items.menu'])
                ->where('courier_id', $userId)
                ->where('order_status', 'dikirim')
                ->orderByDesc('created_at')
                ->get()
                ->map(function ($order) {
                    return [
                        'order_number' => $order->order_number,
                        'total_price' => $order->total_price,
                        'address' => $order->address,
                        'delivery_date' => $order->delivery_date,
                        'delivery_time' => $order->delivery_time,
                        'created_at' => $order->created_at->format('d M Y H:i'),
                    ];
                });
            return $this->success($orders, 'Daftar pengantaran saya berhasil dimuat');
        } catch (\Exception $e) {
            Log::error('Error fetching my deliveries: ' . $e->getMessage());
            return $this->error('Terjadi kesalahan pada server.', 500);
        }
    }

    public function assignOrder(Request $request, $orderNumber): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
        ]);

        try {
            $order = Order::where('order_number', $orderNumber)->firstOrFail();
            if ($order->courier_id) {
                return $this->error('Pesanan sudah ditugaskan kepada kurir lain.', 400);
            }

            $order->courier_id = $request->user_id;
            $order->save();

            return $this->success(null, 'Pesanan berhasil ditugaskan.');
        } catch (\Exception $e) {
            Log::error('Error assigning order: ' . $e->getMessage());
            return $this->error('Gagal menugaskan pesanan.', 500);
        }
    }

    public function completeOrder(Request $request): JsonResponse
    {
        $request->validate([
            'arrival_proof' => 'required|image|max:2048',
            'order_number' => 'required|exists:orders,order_number',
        ]);

        try {
            $order = Order::where('order_number', $request->order_number)->firstOrFail();
            if ($order->order_status !== 'dikirim') {
                return $this->error('Pesanan tidak dalam status dikirim.', 400);
            }

            // Simpan bukti pengantaran
            $proofPath = $request->file('arrival_proof')->store('bukti-pengantaran', 'public');
            $order->arrival_proof = $proofPath;
            $order->order_status = 'selesai';
            $order->save();

            return $this->success(null, 'Pesanan berhasil diselesaikan.');
        } catch (\Exception $e) {
            Log::error('Error completing order: ' . $e->getMessage());
            return $this->error('Gagal menyelesaikan pesanan.', 500);
        }
    }

}
