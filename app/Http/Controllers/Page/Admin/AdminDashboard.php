<?php

namespace App\Http\Controllers\Page\Admin;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AdminDashboard extends Controller
{
    public function show()
    {
        return view('pages.admin.dashboard');
    }

    public function getUserOrderStats(Request $request)
    {
        try {
            // Tanggal default: 1 bulan terakhir
            $start = Carbon::parse($request->start ?? now()->startOfMonth());
            $end = Carbon::parse($request->end ?? now()->endOfMonth())->endOfDay();

            // Statistik
            $userCount = User::count();
            $menuCount = Menu::count();

            $orderStats = Order::whereBetween('created_at', [$start, $end])
                ->selectRaw("order_status, COUNT(*) as count")
                ->groupBy('order_status')
                ->pluck('count', 'order_status');

            return response()->json([
                'userCount' => $userCount,
                'menuCount' => $menuCount,
                'orders' => $orderStats
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getUserOrderStats: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return response()->json([
                'error' => 'Failed to retrieve statistics.'
            ], 500);
        }
    }
}
