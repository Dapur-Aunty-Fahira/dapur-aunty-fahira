<?php

namespace App\Http\Controllers\Page\Admin;

use App\Models\ActivityLogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboard extends Controller
{
    public function show()
    {
        return view('pages.admin.dashboard');
    }

    public function getActivityLogs(Request $request)
    {
        $search = $request->input('search.value'); // get the search value
        $length = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderDirection = $request->input('order.0.dir');
        $columns = $request->input('columns');
        $orderColumnName = $columns[$orderColumnIndex]['data'] ?? 'created_at';

        $query = ActivityLogs::with('user')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('type', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhere('trace_id', 'like', "%$search%")
                        ->orWhere('url', 'like', "%$search%")
                        ->orWhere('ip_address', 'like', "%$search%")
                        ->orWhere('user_agent', 'like', "%$search%")
                        ->orWhere('status', 'like', "%$search%");
                });
            });

        $recordsTotal = $query->count();

        $data = $query->orderBy($orderColumnName, $orderDirection)
            ->skip($start)
            ->take($length)
            ->get();

        return response()->json([
            'data' => $data,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'draw' => intval($request->input('draw'))
        ]);
    }
}
