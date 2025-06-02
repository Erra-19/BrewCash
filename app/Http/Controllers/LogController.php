<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log::with(['user', 'order', 'store'])
            ->latest();

        // Optional filtering
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('order_id')) {
            $query->where('order_id', $request->order_id);
        }
        if ($request->filled('store_id')) {
            $query->where('store_id', $request->store_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $query->paginate(25);

        // For filter dropdowns
        $users = User::orderBy('name')->get();
        $stores = Store::orderBy('store_name')->get();

        return view('backend.v_log.index', compact('logs', 'users', 'stores'));
    }
}