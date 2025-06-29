<?php

namespace App\Http\Controllers\Page\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        try {
            return view("pages.admin.report");
        } catch (\Throwable $e) {
            Log::error("ReportController@index: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Terjadi kesalahan saat membuka halaman laporan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $perPage = $request->input('length', 10);
            $start = $request->input('start', 0);
            $draw = intval($request->input('draw'));

            $orderStatus = $request->input('order_status');
            $paymentStatus = $request->input('payment_status');

            $query = Order::with(['user', 'address', 'items.menu']);

            if (!empty($orderStatus)) {
                $query->where('order_status', $orderStatus);
            }

            $total = Order::count();
            $filtered = $query->count();

            $orders = $query->skip($start)->take($perPage)->get();

            $data = $orders->map(function ($order) {
                return [
                    'order_number' => $order->order_number,
                    'user_name' => $order->user->name ?? '-',
                    'menu_list' => $order->items->pluck('menu.name')->unique()->implode(', '),
                    'total_quantity' => $order->items->sum('quantity'),
                    'total_price' => number_format($order->total_price, 0, ',', '.'),
                    'delivery_date' => $order->delivery_date ?? '-',
                    'delivery_time' => $order->delivery_time ?? '-',
                    'full_address' => $order->address->address ?? '-',
                    'order_status' => ucfirst($order->order_status),
                    'created_at' => $order->created_at->format('Y-m-d H:i'),
                    'updated_at' => $order->updated_at->format('Y-m-d H:i'),
                ];
            });

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $total,
                'recordsFiltered' => $filtered,
                'data' => $data,
            ]);
        } catch (\Throwable $e) {
            Log::error('OrderController@show error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data pesanan.',
                'data' => [],
            ], 500);
        }
    }


}
