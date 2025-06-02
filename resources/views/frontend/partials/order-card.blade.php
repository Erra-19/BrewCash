<div class="order-card" style="background:#fff; border:2px solid #366842; border-radius:18px; padding:1.5rem; margin-bottom:1rem;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <span style="font-weight:bold;">Order #{{ $order->order_id }}</span>
        <span class="order-status">{{ ucfirst($order->status) }}</span>
    </div>
    <div>
        <span style="color:#888;">User:</span>
        <span style="font-weight:500;">{{ $order->user->name ?? $order->user_id }}</span>
    </div>
    <div>
        <span style="color:#888;">Total:</span>
        <span style="font-weight:600;">Rp{{ number_format($order->total_price,0,',','.') }}</span>
    </div>
    <div>
        <span style="color:#888;">Created:</span>
        {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}
    </div>
    <button type="button" class="btn view-details-btn" data-order-id="{{ $order->order_id }}">
        View Details
    </button>
    <div class="order-details-expand" id="details-{{ $order->order_id }}" style="display:none; margin-top:1rem;">
        <div>
            <strong>Items:</strong>
            <ul>
                @foreach($order->products as $product)
                    <li>
                        {{ $product->product_name }} x {{ $product->pivot->ordered_amount }}
                        - Rp{{ number_format($product->pivot->subtotal,0,',','.') }}
                        @if($product->modifiers && $product->modifiers->count())
                            <ul>
                                @foreach($product->modifiers as $mod)
                                    <li>
                                        {{ $mod->mod_name }} x {{ $mod->pivot->quantity }}
                                        (+Rp{{ number_format($mod->pivot->price_at_time,0,',','.') }})
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <form class="payment-form" data-order-id="{{ $order->order_id }}">
            <div>
                <label>Payment Method:</label>
                <select name="payment_method" required>
                    <option value="Cash">Cash</option>
                    <option value="Card">Card</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>
            </div>
            <div>
                <label>Paid Amount:</label>
                Rp<input type="number" name="paid_amount" min="{{ $order->total_price }}" required>
            </div>
            <div>
                <label>Change:</label>
                <input type="text" name="change" readonly>
            </div>
            <button type="submit">Confirm Payment</button>
            <button type="button" class="close-details-btn">Close</button>
        </form>
    </div>
</div>