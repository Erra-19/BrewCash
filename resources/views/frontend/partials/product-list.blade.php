<div class="products-grid">
    @forelse($products as $product)
        <div class="product-card"
             data-product='{!! json_encode([
                "id" => $product->product_id,
                "name" => $product->product_name,
                "price" => $product->product_price,
                "image" => $product->product_image
                    ? asset("storage/img-product/" . $product->product_image)
                    : asset("storage/img-staff/img-default.jpg"),
                "modifiers" => $product->modifiers_for_json
             ]) !!}'>
            @if($product->product_image)
                <img src="{{ asset('storage/img-product/' . $product->product_image) }}" alt="{{ $product->product_name }}">
            @else
                <img src="{{ asset('storage/img-staff/img-default.jpg') }}" alt="Default Avatar">
            @endif
            <h3>{{ $product->product_name }}</h3>
            <h4>Rp{{ $product->product_price }}</h4>
            <button class="add-to-order-btn">+</button>
        </div>
    @empty
        <p>No items available in this category.</p>
    @endforelse
</div>