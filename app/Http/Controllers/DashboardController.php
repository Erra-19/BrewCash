<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Log;
use App\Models\Order;

class DashboardController extends Controller
{
    public function dashBackend()
    {
        // ... (All the user and store logic remains the same) ...
        $user = Auth::user();
        $stores = collect();
        $staffStoreSelectionMode = session('staff_store_selection_mode');
        $recentLogs = collect();
        $chartData = null;
        $activeStoreId = session('active_store_id');

        if ($user->isOwner()) {
            $stores = Store::where('user_id', $user->user_id)
                ->orderBy('store_name', 'asc')
                ->get();
        } elseif ($user->isStaff()) {
            $activeStaffAdminStoreId = session('active_staff_admin_store_id');

            if ($staffStoreSelectionMode === 'single_admin' && $activeStaffAdminStoreId) {
                $store = $user->staffs()
                    ->where('stores.store_id', $activeStaffAdminStoreId)
                    ->wherePivot('status', 1)
                    ->first();
                if ($store) {
                    $stores = collect([$store]);
                } else {
                    $stores = $user->staffs()
                        ->wherePivot('status', 1)
                        ->orderBy('store_name', 'asc')
                        ->get();
                    if (session('active_store_id') === $activeStaffAdminStoreId) {
                        session()->forget('active_store_id');
                    }
                }
            } else {
                $stores = $user->staffs()
                    ->wherePivot('status', 1)
                    ->orderBy('store_name', 'asc')
                    ->get();
            }
        }


        if ($activeStoreId) {
            // Fetch recent logs for the active store
            $recentLogs = Log::where('store_id', $activeStoreId)
                             ->orderBy('created_at', 'desc')
                             ->take(3)
                             ->get();


            // ========================= HIGHLIGHTED FIX =========================
            
            // 1. Get all unique order_id's for the active store from the logs table.
            $orderIdsForStore = Log::where('store_id', $activeStoreId)
                                     ->where('type', 'Order')
                                     ->whereNotNull('order_id')
                                     ->distinct()
                                     ->pluck('order_id');

            // 2. Proceed only if we found order IDs for this store
            if ($orderIdsForStore->isNotEmpty()) {
                // 3. Query the orders table using the collected IDs (NO where('store_id'))
                $orders = Order::with('user')
                                ->whereIn('order_id', $orderIdsForStore)
                                ->where('status', 'paid')
                                ->orderBy('created_at')
                                ->get();
            // ======================= END OF HIGHLIGHTED FIX =======================

                if ($orders->isNotEmpty()) {
                    // ... (The rest of the chart data logic remains the same)
                    $salesByDay = $orders->groupBy(function($order) {
                        return $order->created_at->format('Y-m-d');
                    })->map(function($day) {
                        return $day->sum('total_price');
                    });
                    $topUsers = $orders->groupBy('user_id')
                        ->map(function($userOrders, $userId) {
                            $userName = optional($userOrders->first()->user)->name ?? 'Unknown User';
                            return [ 'user_id' => $userId, 'name' => $userName, 'total_sales' => $userOrders->sum('total_price'), ];
                        })->sortByDesc('total_sales')->take(5)->values();
                    $userBreakdown = [];
                    foreach ($topUsers as $topUser) {
                        $userSalesByDay = $orders->where('user_id', $topUser['user_id'])
                            ->groupBy(function($order) { return $order->created_at->format('Y-m-d');
                            })->map(function($day) { return $day->sum('total_price'); });
                        $userBreakdown[$topUser['user_id']] = [ 'labels' => $userSalesByDay->keys(), 'data'   => $userSalesByDay->values(), ];
                    }
                    $chartData = [ 'main' => [ 'labels' => $salesByDay->keys(), 'data'   => $salesByDay->values(), ], 'top_users' => $topUsers, 'user_breakdown' => $userBreakdown, ];
                }
            }
        }

        return view('backend.v_dash.index', [
            'title' => 'Dashboard',
            'sub' => 'Dashboard',
            'stores' => $stores,
            'staffStoreSelectionMode' => $staffStoreSelectionMode,
            'recentLogs' => $recentLogs,
            'chartData' => $chartData,
        ]);
    }
}