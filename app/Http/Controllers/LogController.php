<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\UserStore;
use PDF;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // If no store is active, prompt the user to select one.
        $activeStoreId = session('active_store_id');
        if (!$activeStoreId) {
            return view('backend.v_log.index', ['requires_store' => true]);
        }

        // Correctly query logs for the active store and eager load relationships.
        $query = Log::with(['user', 'order', 'store'])
                    ->where('store_id', $activeStoreId)
                    ->latest();

        // Apply filters from the request
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
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('store_role')) {
            $userIdsWithRole = UserStore::where('store_id', $activeStoreId)
                ->where('store_role', $request->store_role)
                ->pluck('user_id');
            $query->whereIn('user_id', $userIdsWithRole);
        }

        // Handle PDF export
        if ($request->has('print')) {
            $logs = $query->get();
            $pdf = PDF::loadView('backend.v_log.pdf', [
                'logs' => $logs,
                'filters' => $request->all()
            ]);
            return $pdf->download('log-report-' . now()->format('Y-m-d') . '.pdf');
        }

        // Paginate the results for the view
        $logs = $query->paginate(25)->withQueryString();

        // For filter dropdowns
        $store = Store::find($activeStoreId);
        $usersInStore = $store ? $store->staffs()->orderBy('name')->get() : collect();
        $storeRoles = UserStore::where('store_id', $activeStoreId)
            ->select('store_role')
            ->distinct()
            ->orderBy('store_role')
            ->pluck('store_role');

        return view('backend.v_log.index', [
            'requires_store' => false,
            'logs' => $logs,
            'users' => $usersInStore,
            'storeRoles' => $storeRoles,
        ]);
    }
}