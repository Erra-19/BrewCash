<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\ProductOrderModifier;
use App\Models\Product;
use App\Models\Modifier;
use App\Models\Log;

class OrderController extends Controller
{
    /**
     * Store a new order from POS.
     * Expects JSON payload:
     * {
     * items: [
     * {
     * product_id: "...",
     * qty: 2,
     * subtotal: 1000,
     * modifiers: [
     * { id: "...", price: 100, qty: 1 }
     * ]
     * }
     * ]
     * }
     */
    public function index(Request $request) {
        $status = $request->input('status', 'Open');
        $user = Auth::user();
        $storeRole = '';
        $totalOrders = Order::where('user_id', $user->user_id)->count();
        $orders = Order::with(['user', 'products.modifiers'])->where('status', $status)->latest()->get();
        return view('frontend.order', compact('orders', 'user', 'storeRole', 'totalOrders'));
    }
    public function store(Request $request)
{
    $payload = $request->validate([
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,product_id',
        'items.*.qty' => 'required|integer|min:1',
        'items.*.subtotal' => 'required|numeric|min:0',
        'items.*.modifiers' => 'array',
        'items.*.modifiers.*.id' => 'required_with:items.*.modifiers|exists:modifiers,mod_id',
        'items.*.modifiers.*.price' => 'required_with:items.*.modifiers|numeric|min:0',
        'items.*.modifiers.*.qty' => 'sometimes|integer|min:1',
    ]);

    $user = Auth::user();

    // --- BEGIN TRANSACTION ---
    \DB::beginTransaction();

    try {
        // --- START: AGGREGATION LOGIC ---
        // This block ensures that items with the same product_id and same modifiers
        // are combined by summing their quantities.
        $aggregatedItems = [];
        foreach ($payload['items'] as $item) {
            // Create a unique "fingerprint" for the item based on its product_id and modifiers.
            $modifiers = $item['modifiers'] ?? [];

            // Sort modifiers by 'id' to create a consistent key, regardless of selection order.
            usort($modifiers, fn($a, $b) => strcmp($a['id'], $b['id']));

            // Use http_build_query to create a stable string representation from the modifiers array.
            $modifierKey = http_build_query($modifiers);
            $aggregationKey = $item['product_id'] . '|' . $modifierKey;

            // Aggregate items based on this unique key.
            if (isset($aggregatedItems[$aggregationKey])) {
                // If this exact item configuration already exists, just update the quantity.
                $aggregatedItems[$aggregationKey]['qty'] += $item['qty'];
            } else {
                // Otherwise, add the new item configuration to the list.
                $aggregatedItems[$aggregationKey] = $item;
            }
        }
        // --- END: AGGREGATION LOGIC ---

        // Get staff prefix
        $prefix = strtoupper(substr($user->name, 0, 2));

        // Lock the orders table and get the highest sequential number
        $lastOrder = \DB::table('orders')
            ->select('order_id')
            ->orderByDesc('created_at')
            ->lockForUpdate() // prevents race conditions!
            ->first();

        if ($lastOrder && preg_match('/OO(\d{3,})$/', $lastOrder->order_id, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        $orderNumberStr = str_pad($nextNumber, 3, "0", STR_PAD_LEFT);
        $orderId = "{$prefix}OO{$orderNumberStr}";

        // Calculate total using the NEW aggregated items list.
        $total = 0;
        foreach ($aggregatedItems as $item) {
            $lineTotal = ($item['subtotal'] + collect($item['modifiers'] ?? [])->sum('price')) * $item['qty'];
            $total += $lineTotal;
        }

        // Create order
        $order = Order::create([
            'order_id' => $orderId,
            'user_id' => $user->user_id,
            'total_price' => $total,
            'status' => 'Open',
            'paid_amount' => 0,
            'change' => 0,
            'payment_method' => null,
            'paid_at' => null,
            'cancelled_at' => null,
        ]);

        // Insert products and modifiers using the NEW aggregated items list.
        foreach ($aggregatedItems as $item) {
            $productId = $item['product_id'];
            $qty = $item['qty'];
            $subtotal = $item['subtotal'];
            $productOrder = ProductOrder::create([
                'order_id' => $orderId,
                'product_id' => $productId,
                'ordered_amount' => $qty,
                'subtotal' => $subtotal,
            ]);
            $lineId = $productOrder->line_id;
        
            foreach ($item['modifiers'] ?? [] as $mod) {
                ProductOrderModifier::create([
                    'line_id' => $lineId,
                    'mod_id' => $mod['id'],
                    'quantity' => $mod['qty'] ?? 1,
                    'price_at_time' => $mod['price'],
                ]);
            }
        }

        // Log the order (1 log row with full original payload)
        Log::create([
            'user_id' => $user->user_id,
            'order_id' => $orderId,
            'type' => 'order',
            'action' => 'Order placed',
            'meta' => json_encode($payload), // It's often useful to log the original request
        ]);

        \DB::commit();

        return response()->json(['success' => true, 'order_id' => $orderId, 'total' => $total]);
    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('Order store error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
}


    /**
     * Show an order with all details (products, modifiers).
     */
    public function show($orderId)
{
    $order = Order::with(['productOrders.modifiers.modifier', 'productOrders.product'])->where('order_id', $orderId)->firstOrFail();

    $products = [];
    foreach ($order->productOrders as $productOrder) {
        $product = $productOrder->product;
        $modifiers = $productOrder->modifiers;
        $modifierPrice = $modifiers->sum(fn($m) => $m->price_at_time * $m->quantity);

        $products[] = [
            'product_id' => $product->product_id,
            'name' => $product->product_name,
            'qty' => $productOrder->ordered_amount,
            'subtotal' => $productOrder->subtotal,
            'modifiers' => $modifiers->map(function($m) {
                return [
                    'id' => $m->mod_id,
                    'name' => $m->modifier->mod_name ?? '',
                    'qty' => $m->quantity,
                    'price' => $m->price_at_time,
                ];
            })->toArray(),
            'line_price' => ($productOrder->subtotal + $modifierPrice) * $productOrder->ordered_amount,
        ];
    }
    return view('frontend.order-detail', compact('order', 'products'));
}
    public function pay(Request $request, $orderId)
{
    $order = Order::where('order_id', $orderId)->where('status', 'Open')->firstOrFail();

    $data = $request->validate([
        'payment_method' => 'required|string',
        'paid_amount' => 'required|numeric|min:'.$order->total_price,
    ]);
    $change = $data['paid_amount'] - $order->total_price;

    $order->update([
        'status' => 'Paid',
        'paid_amount' => $data['paid_amount'],
        'change' => $change,
        'payment_method' => $data['payment_method'],
        'paid_at' => now(),
    ]);

    Log::create([
        'user_id' => Auth::id(),
        'order_id' => $orderId,
        'type' => 'order',
        'action' => 'Order paid',
        'meta' => json_encode([
            'payment_method' => $data['payment_method'],
            'paid_amount' => $data['paid_amount'],
            'change' => $change,
        ]),
    ]);

    return response()->json(['success' => true, 'change' => $change]);
}
public function cancel($orderId)
{
    $order = Order::where('order_id', $orderId)->where('status', 'Open')->firstOrFail();
    $order->update([
        'status' => 'Cancelled',
        'cancelled_at' => now(),
    ]);
    Log::create([
        'user_id' => Auth::id(),
        'order_id' => $orderId,
        'type' => 'order',
        'action' => 'Order cancelled',
        'meta' => '',
    ]);
    return response()->json(['success' => true]);
}
public function ajaxList(Request $request)
{
    $status = $request->input('status', 'Open');
    $orders = Order::with(['user', 'products.modifiers'])->where('status', $status)->latest()->get();
return view('frontend.partials.order-progress', compact('orders', 'status'));
}
}