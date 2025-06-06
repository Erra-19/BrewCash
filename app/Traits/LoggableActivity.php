<?php

namespace App\Traits;

use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait LoggableActivity
{
    /**
     * Create a new log entry.
     *
     * @param string      $type       The category of the log (e.g., 'Staff', 'Authentication', 'Order').
     * @param string      $action     A human-readable description of the action.
     * @param array|null  $meta       Optional associative array for extra details.
     * @param string|null $store_id   Optional store ID to associate with the log.
     * @param string|null $order_id   Optional order ID to associate with the log.
     */
    public function logActivity(string $type, string $action, ?array $meta = null, ?string $store_id = null, ?string $order_id = null): void
    {
        // If no store_id is provided, try to get the active one from the session.
        $store_id = $store_id ?? session('active_store_id');
        
        Log::create([
            'user_id'  => Auth::id() ?? Auth::guard('staff')->id(),
            'type'     => $type,
            'action'   => $action,
            'meta'     => $meta,
            'store_id' => $store_id,
            'order_id' => $order_id,
        ]);
    }
}