<div class="orders-grid">
    @forelse($orders as $order)
        <div class="order-card">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <span style="font-weight:bold;font-size:1.05rem;color:#103E13;">Order #{{ $order->order_id }}</span>
                <span class="order-status {{ $order->status }}">{{ $order->status }}</span>
            </div>
            <div>
                <div style="margin-bottom:0.4em;">
                    <span style="color:#888;">User:</span>
                    <span style="font-weight:500;">{{ $order->user->name ?? $order->user_id }}</span>
                </div>
                <div style="margin-bottom:0.4em;">
                    <span style="color:#888;">Total:</span>
                    <span class="order-total">Rp{{ number_format($order->total_price,0,',','.') }}</span>
                </div>
                <div style="margin-bottom:0.4em;">
                    <span style="color:#888;">Created:</span>
                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}
                </div>
                @if($order->status == 'Paid')
                    <div>
                        <span style="color:#888;">Paid at:</span>
                        {{ $order->paid_at ? \Carbon\Carbon::parse($order->paid_at)->format('d M Y H:i') : '-' }}
                    </div>
                @elseif($order->status == 'Cancelled')
                    <div>
                        <span style="color:#888;">Cancelled at:</span>
                        {{ $order->cancelled_at ? \Carbon\Carbon::parse($order->cancelled_at)->format('d M Y H:i') : '-' }}
                    </div>
                @endif
            </div>
            <button type="button" class="btn view-details-btn" data-order-id="{{ $order->order_id }}">
                View Details
            </button>
            <div class="order-details-expand" id="details-{{ $order->order_id }}">
                <div class="order-details-box">
                    <strong>Order Details</strong>
                    <ul>
                        @foreach($order->products as $product)
                            <li>
                                <span style="font-weight:500;">{{ $product->product_name }}</span>
                                × <span style="font-weight:600;">{{ $product->pivot->ordered_amount }}</span>
                                <span style="color:#6e915a;">- Rp{{ number_format($product->pivot->subtotal,0,',','.') }}</span>
                                @if($product->modifiers && $product->modifiers->count())
                                    <ul class="modifier-list">
                                        @foreach($product->modifiers as $mod)
                                            <li>
                                                <span>{{ $mod->mod_name }}</span>
                                                × {{ $mod->pivot->quantity }}
                                                <span class="modifier-price">(+Rp{{ number_format($mod->pivot->price_at_time,0,',','.') }})</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    <div class="details-total">
                        Total: Rp{{ number_format($order->total_price,0,',','.') }}
                    </div>
                </div>
                @if($order->status == 'Open')
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
                        <span class="paid-prefix">Rp</span>
                        <input type="number" name="paid_amount" min="{{ $order->total_price }}" required>
                    </div>
                    <div>
                        <label>Change:</label>
                        <input type="text" name="change" readonly>
                    </div>
                    <div class="btn-row">
                        <button type="submit" class="confirm-payment-btn">Confirm Payment</button>
                        <button type="button" class="cancel-order-btn">Cancel</button>
                        <button type="button" class="close-details-btn">Close</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;text-align:center;color:#bbb;font-size:1.15rem;">
            No {{ strtolower($status) }} orders found.
        </div>
    @endforelse
</div>