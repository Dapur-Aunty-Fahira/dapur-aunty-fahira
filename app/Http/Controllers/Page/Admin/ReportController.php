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

            // Ambil informasi sorting
            $orderColumnIndex = $request->input('order.0.column');
            $orderDir = $request->input('order.0.dir', 'asc');
            $columns = $request->input('columns');
            $orderColumn = $columns[$orderColumnIndex]['data'] ?? 'created_at';

            // Mapping nama kolom frontend ke kolom database
            $sortable = [
                'order_number' => 'order_number',
                'user_name' => 'users.name', // pakai join
                'total_quantity' => '', // handled manually
                'total_price' => 'total_price',
                'delivery_date' => 'delivery_date',
                'delivery_time' => 'delivery_time',
                'full_address' => 'customer_addresses.address', // pakai join
                'order_status' => 'order_status',
                'created_at' => 'created_at',
                'updated_at' => 'updated_at',
            ];

            $sortColumn = $sortable[$orderColumn] ?? 'created_at';

            $query = Order::with(['user', 'address', 'items.menu']);

            // Filtering
            if (!empty($orderStatus)) {
                $query->where('order_status', $orderStatus);
            }

            // Join tambahan untuk user dan address jika sorting dipakai
            if (in_array($orderColumn, ['user_name', 'full_address'])) {
                $query->leftJoin('users', 'orders.user_id', '=', 'users.id')
                    ->leftJoin('customer_addresses', 'orders.address_id', '=', 'customer_addresses.id')
                    ->select('orders.*');
            }

            $total = Order::count();
            $filtered = $query->count();

            // Sorting
            if (!empty($sortColumn)) {
                $query->orderBy($sortColumn, $orderDir);
            }

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
