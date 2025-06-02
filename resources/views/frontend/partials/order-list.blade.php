@php
    // $products: array of product lines, each:
    // [
    //   'product_id' => ...,
    //   'name' => ...,
    //   'qty' => ...,
    //   'subtotal' => ...,
    //   'modifiers' => [ [ 'id'=>..., 'name'=>..., 'qty'=>..., 'price'=>... ], ... ],
    //   'line_price' => ...,
    // ]
    // $total: total price (int)
@endphp

@if(empty($products))
    <p>No items yet.</p>
@else
<div class="order-list-styled">
    <hr>
    <div class="order-list-header">
        <span class="order-list-col order-list-col-item">Item</span>
        <span class="order-list-col order-list-col-qty">Qty</span>
        <span class="order-list-col order-list-col-price">Subtotal</span>
    </div>
    <div class="order-list-body">
        @forelse($products as $prod)
            <div class="order-list-row">
                <div class="order-list-col order-list-col-item">
                    {{ $prod['name'] }}
                    @if(!empty($prod['modifiers']))
                        <div class="order-list-mods">
                            @foreach($prod['modifiers'] as $mod)
                                <div class="order-list-mod">
                                    <small>({{ $mod['name'] }}{{ $mod['qty'] > 1 ? ' x'.$mod['qty'] : '' }})</small>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="order-list-col order-list-col-qty">{{ $prod['qty'] }}</div>
                <div class="order-list-col order-list-col-price">{{ 'Rp'.number_format($prod['line_price'], 0, ',', '.') }}</div>
            </div>
        @empty
            <div class="order-list-row order-list-empty">No Order Selected Yet.</div>
        @endforelse
    </div>
    <hr>
    <div class="order-list-total-row">
        <span class="order-list-total-label">Total</span>
        <span class="order-list-total-value">{{ 'Rp'.number_format($total, 0, ',', '.') }}</span>
    </div>
</div>
@endif