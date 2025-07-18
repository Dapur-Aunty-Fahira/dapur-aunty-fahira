<?php

namespace App\Http\Controllers\Page\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        try {
            return view("pages.admin.order");
        } catch (\Throwable $e) {
            Log::error("OrderController@index: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat membuka halaman pesanan.');
        }
    }

    /**
     * Display the specified resource (for DataTables).
     */
    public function show(Request $request)
    {
        try {
            $perPage = $request->input('length', 10);
            $start = $request->input('start', 0);
            $draw = intval($request->input('draw'));
            $orderStatus = $request->input('order_status');
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');
            $columns = $request->input('columns');
            $searchValue = $request->input('search.value');
            $orderColumn = $columns[$orderColumnIndex]['data'] ?? 'created_at';

            // Map column names to database columns
            $sortable = [
                'order_number' => 'orders.order_number',
                'user_name' => 'users.name',
                'total_quantity' => null, // handled after fetching
                'total_price' => 'orders.total_price',
                'delivery_date' => 'orders.delivery_date',
                'delivery_time' => 'orders.delivery_time',
                'full_address' => 'customer_addresses.address',
                'order_status' => 'orders.order_status',
                'created_at' => 'orders.created_at',
                'updated_at' => 'orders.updated_at',
            ];
            $sortColumn = $sortable[$orderColumn] ?? 'orders.created_at';

            // Build query
            $query = Order::with(['user', 'address', 'items.menu'])
                ->join('users', 'orders.user_id', '=', 'users.user_id')
                ->join('customer_addresses', 'orders.address_id', '=', 'customer_addresses.address_id');

            if (!empty($orderStatus)) {
                $query->where('orders.order_status', $orderStatus);
            }

            // Add search functionality
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('orders.order_number', 'like', "%{$searchValue}%")
                        ->orWhere('users.name', 'like', "%{$searchValue}%")
                        ->orWhere('orders.total_price', 'like', "%{$searchValue}%")
                        ->orWhere('orders.delivery_date', 'like', "%{$searchValue}%")
                        ->orWhere('orders.delivery_time', 'like', "%{$searchValue}%")
                        ->orWhere('customer_addresses.address', 'like', "%{$searchValue}%")
                        ->orWhere('orders.order_status', 'like', "%{$searchValue}%");
                });
            }

            // Get total records before filtering
            $totalOrders = Order::count();

            // Get filtered count
            $filteredOrders = (clone $query)->count();

            // Apply sorting, pagination
            if ($sortColumn) {
                $query->orderBy($sortColumn, $orderDir);
            }
            $orders = $query
                ->select('orders.*')
                ->skip($start)
                ->take($perPage)
                ->get();

            // Prepare data for DataTables
            $data = [];
            foreach ($orders as $order) {
                $data[] = [
                    'order_number' => $order->order_number,
                    'user_name' => $order->user->name ?? '-',
                    //combine each item with quantity and price
                    'menu_items' => $order->items->map(function ($item) {
                        return $item->menu->name . ' (x' . $item->quantity . '. @ Rp. ' . number_format($item->menu->price * $item->quantity, 0, ',', '.') . ')';
                    })->implode(', '),
                    'total_quantity' => $order->items->sum('quantity'),
                    'total_price' => $order->total_price,
                    'delivery_date' => $order->delivery_date ?? '-',
                    'delivery_time' => $order->delivery_time ?? '-',
                    'full_address' => $order->address->address ?? '-',
                    'order_status' => $order->order_status,
                    'payment_proof' => $order->payment_proof ?? '-',
                    'payment_status' => $order->payment_status,
                    'cancellation_reason' => $order->cancellation_reason ?? '-',
                    'created_at' => $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : '',
                    'updated_at' => $order->updated_at ? $order->updated_at->format('Y-m-d H:i:s') : '',
                ];
            }

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalOrders,
                'recordsFiltered' => $filteredOrders,
                'data' => $data,
            ]);
        } catch (\Throwable $e) {
            Log::error("OrderController@show: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data pesanan.'], 500);
        }
    }

    public function detail($orderNumber)
    {
        try {
            $order = Order::with(['user', 'address', 'items.menu'])
                ->where('order_number', $orderNumber)
                ->firstOrFail();
            return view('pages.admin.order_detail', compact('order'));
        } catch (\Throwable $e) {
            Log::error("OrderController@detail: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat mengambil detail pesanan.');
        }
    }

    public function updateStatus(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', $orderNumber)->firstOrFail();
            $order_status = $request->input('order_status');
            $payment_status = $request->input('payment_status');
            $validStatuses = ['menunggu konfirmasi', 'diproses', 'dikirim', 'selesai', 'dibatalkan'];
            if (!in_array($order_status, $validStatuses)) {
                return response()->json(['error' => 'Status tidak valid.'], 400);
            }

            if ($payment_status) {
                $validPaymentStatuses = ['Validasi pembayaran', 'Diterima', 'Ditolak'];
                if (!in_array($payment_status, $validPaymentStatuses)) {
                    return response()->json(['error' => 'Status pembayaran tidak valid.'], 400);
                }
                $order->payment_status = $payment_status;
            }
            if ($order_status === 'diproses') {
                $order->processed_at = now();
            } elseif ($order_status === 'dikirim') {
                $order->sent_at = now();
            } elseif ($order_status === 'selesai') {
                $order->arrived_at = now();
                $order->completed_at = now();
            } elseif ($order_status === 'dibatalkan') {
                $order->canceled_by = auth()->id();
                $order->canceled_at = now();
                $order->cancellation_reason = $request->input('cancellation_reason', 'Tidak ada alasan diberikan');
            }
            $order->order_status = $order_status;
            $order->save();
            return response()->json(['success' => true, 'message' => 'Status pesanan berhasil diperbarui.']);
        } catch (\Throwable $e) {
            Log::error("OrderController@updateStatus: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui status pesanan.'], 500);
        }
    }

    public function cancelOrder(Request $request, $order_number)
    {
        try {
            $order = Order::where('order_number', $order_number)->firstOrFail();
            $reason = $request->input('reason');
            if (empty($reason)) {
                return response()->json(['error' => 'Alasan pembatalan tidak boleh kosong.'], 400);
            }
            $order->order_status = 'canceled';
            $order->cancellation_reason = $reason;
            $order->canceled_by = auth()->id();
            $order->canceled_at = now();
            $order->save();
            return response()->json(['success' => true, 'message' => 'Pesanan berhasil dibatalkan.']);
        } catch (\Throwable $e) {
            Log::error("OrderController@cancelOrder: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Terjadi kesalahan saat membatalkan pesanan.'], 500);
        }
    }
}
