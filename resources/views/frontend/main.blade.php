<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrewCash - POS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('backend/dist/css/frontend/cashier-pos.css')}}">
    <link rel="preconnect" href="[https://fonts.googleapis.com](https://fonts.googleapis.com)">
    <link rel="preconnect" href="[https://fonts.gstatic.com](https://fonts.gstatic.com)" crossorigin>
    <link href="[https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Rokkit:wght@500;700&display=swap](https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Rokkit:wght@500;700&display=swap)" rel="stylesheet">
    <link href='[https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css](https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css)' rel='stylesheet'>
</head>
<body>
    <div class="page-wrapper">
    <header class="main-header">
        <div class="header-left">
            <img src="{{asset('frontend/img/icon.png')}}" class="logo"></img>
            <p class="current-date">{{ \Carbon\Carbon::now()->format('l, d F') }}</p>
        </div>
        <div class="staff-order" style="text-align:center;font-weight:bold;">
            Total Orders: {{ $totalOrders }}
        </div>
        <div class="header-right">
            <div class="header-info">
                <a href="{{ route('orders.index') }}" class="report-btn">Orders</a>
            </div>
            <div class="user-profile-dropdown">

                <div class="user-profile">
                    <img src="{{ asset('storage/img-staff/img-default.jpg') }}" alt="User Avatar" class="user-avatar">
                    <div class="user-info">
                        <span class="user-name">{{$user->name}}</span>
                        <span class="user-role">{{$storeRole}}</span>
                    </div>
                </div>
            
                <div class="dropdown-content">
                    <form method="POST" action="{{ route('frontend.logout') }}">
                        @csrf <button type="submit" class="logout-button">Logout</button>
                    </form>
                </div>
            
            </div>
        </div>
    </header>

    <div class="search-and-filters">
        <div class="search-bar">
            <i class='bx bx-search'></i>
            <input type="text" placeholder="Search">
        </div>
    </div>
    <div class="pos-root">
        <div class="pos-container" id="mainContent">
            <nav class="category-nav">
                @foreach($categories as $category)
                    <a href="#" 
                    class="category-tab {{ $activeCategory && $activeCategory->category_id == $category->category_id ? ' active' : '' }}" 
                    data-category-id="{{ $category->category_id }}">
                        <h3>{{ $category->category_name }}</h3>
                        <p>{{ $category->products_count }} items</p>
                    </a>
                @endforeach
            </nav>
            <div id="menu-products">
                @include('frontend.partials.product-list', ['products' => $products])
            </div> 
        </div>
        <div id="productOverlay" class="product-overlay" style="display:none;">
            <div class="overlay-content">
                <butto class="addon-chevron" id="closeProductOverlayBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <path d="M7 10l5 5 5-5" stroke="#366842" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </butto>
                <div class="product-info">
                    <div class="overlay-product-image">
                        <img id="overlayProductImg" src="" alt="Product">
                    </div>
                    <h3 id="overlayProductName"></h3>
                    <div id="overlayProductPrice"></div>
                    <div class="qty-controls">
                        <button type="button" id="qtyMinus" class="qty-btn">-</button>
                        <span id="orderQty">1</span>
                        <button type="button" id="qtyPlus" class="qty-btn">+</button>
                    </div>
                </div>
                <div id="addonList"></div>
                <button id="addOrderBtn" class="add-order-btn">Add To Order</button>
            </div>
        </div>
        <div class="order-overlay" id="orderOverlay">
            <div class="order-content">
                <button class="close-overlay-btn" id="closeOverlayBtn" aria-label="Close Order Overlay">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 12" width="10" height="15">
                        <path d="M0.590027 10.59L5.17003 6L0.590027 1.41L2.00003 0L8.00003 6L2.00003 12L0.590027 10.59Z" fill="currentColor"/>
                    </svg>
                </button>
                <h2>Order List</h2>
                <div class="order-list">
                </div>
                <div class="confirm-order-btn-container">
                    <button class="confirm-order-btn">Confirm Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        let cart = [];
        let currentProduct = null;
        let currentQty = 1;
        
        function formatRupiah(num) {
            return "Rp" + Number(num).toLocaleString("id-ID");
        }
        
        function updateOverlayPrice() {
            if (!currentProduct) return;
            let base = Number(currentProduct.price);
            let addonTotal = 0;
            document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {
                addonTotal += Number(cb.getAttribute('data-price') || 0);
            });
            let total = (base + addonTotal) * currentQty;
            document.getElementById('overlayProductPrice').textContent = formatRupiah(total);
        }
        
        function attachAddToOrderEvents() {
            document.querySelectorAll('.add-to-order-btn').forEach(btn => {
                btn.onclick = function() {
                    const productCard = this.closest('.product-card');
                    const product = JSON.parse(productCard.getAttribute('data-product'));
                    currentProduct = product;
                    currentQty = 1;
        
                    // Fill overlay
                    document.getElementById('overlayProductImg').src = product.image;
                    document.getElementById('overlayProductName').textContent = product.name;
                    document.getElementById('orderQty').textContent = currentQty;
        
                    // Fill addons
                    let addonHTML = "";
                    product.modifiers.forEach(mod => {
                        addonHTML += `<label class="addon-row">
                            <input type="checkbox" class="addon-checkbox" data-id="${mod.id}" data-price="${mod.price}"> 
                            ${mod.name} <span>+ ${formatRupiah(mod.price)}</span>
                        </label>`;
                    });
                    document.getElementById('addonList').innerHTML = addonHTML;
        
                    // Add listeners for addons
                    document.querySelectorAll('.addon-checkbox').forEach(cb => {
                        cb.addEventListener('change', updateOverlayPrice);
                    });
        
                    // Set initial price
                    updateOverlayPrice();
        
                    // Show overlay
                    document.getElementById('productOverlay').style.display = 'flex';
                }
            });
        }
        
        // Attach on initial load
        attachAddToOrderEvents();
        
        // Category switch (re-attach events)
        document.querySelectorAll('.category-tab').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                let categoryId = this.getAttribute('data-category-id');
                fetch("{{ route('products.byCategory') }}?category_id=" + categoryId)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('menu-products').innerHTML = html;
                        // Update active tab
                        document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        // Re-attach add-to-order events to new products
                        attachAddToOrderEvents();
                    });
            });
        });
        
        // Quantity controls
        document.getElementById('qtyMinus').addEventListener('click', function() {
            if(currentQty > 1) {
                currentQty--;
                document.getElementById('orderQty').textContent = currentQty;
                updateOverlayPrice();
            }
        });
        document.getElementById('qtyPlus').addEventListener('click', function() {
            currentQty++;
            document.getElementById('orderQty').textContent = currentQty;
            updateOverlayPrice();
        });
        
        document.getElementById('closeProductOverlayBtn').addEventListener('click', function() {
            document.getElementById('productOverlay').style.display = 'none';
        });
        
        document.getElementById('addOrderBtn').addEventListener('click', function() {
    // Collect selected addons and qty
    let selected = [];
    document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {
        selected.push({
            id: cb.getAttribute('data-id'),
            name: cb.parentElement.textContent.trim(),
            price: Number(cb.getAttribute('data-price')),
            qty: 1 // or let user choose qty per modifier if you implement that
        });
    });

    // Create a unique key for this product+modifiers
    function modifiersKey(mods) {
        // Sort by id for consistent serialization
        return JSON.stringify((mods||[]).slice().sort((a,b) => a.id.localeCompare(b.id)));
    }

    let newProductId = currentProduct.id || currentProduct.product_id;
    let newKey = newProductId + '|' + modifiersKey(selected);

    // Try to find if this configuration already exists in cart
    let found = false;
    for (let item of cart) {
        let itemKey = (item.product_id) + '|' + modifiersKey(item.modifiers);
        if (itemKey === newKey) {
            item.qty += currentQty; // Increment qty
            found = true;
            break;
        }
    }
    if (!found) {
        cart.push({
            product_id: newProductId,
            name: currentProduct.name || currentProduct.product_name,
            qty: currentQty,
            base_price: Number(currentProduct.price),
            modifiers: selected
        });
    }

    // Hide overlay
    document.getElementById('productOverlay').style.display = 'none';

    // Show order overlay
    document.getElementById('orderOverlay').classList.add('active');
    document.getElementById('mainContent').classList.add('squeezed');

    // RENDER ORDER LIST!
    renderOrderList();
});
        
        document.getElementById('closeOverlayBtn').addEventListener('click', function() {
            document.getElementById('orderOverlay').classList.remove('active');
            document.getElementById('mainContent').classList.remove('squeezed');
        });
        
        function renderOrderList() {
    const orderListDiv = document.querySelector('.order-list');
    if (!cart.length) {
        orderListDiv.innerHTML = `
            <div class="order-list-styled">
                <hr>
                <div class="order-list-header">
                    <span class="order-list-col order-list-col-item">Item</span>
                    <span class="order-list-col order-list-col-qty">Qty</span>
                    <span class="order-list-col order-list-col-price">Subtotal</span>
                </div>
                <div class="order-list-body">
                    <div class="order-list-row order-list-empty">No items yet.</div>
                </div>
                <hr>
                <div class="order-list-total-row">
                    <span class="order-list-total-label">Total</span>
                    <span class="order-list-total-value">Rp0</span>
                </div>
            </div>
        `;
        return;
    }

    let total = 0;
    let body = '';
    cart.forEach((item, idx) => {
        const mods = (item.modifiers && item.modifiers.length)
            ? '<div class="order-list-mods">' + item.modifiers.map(mod =>
                `<div class="order-list-mod"><small>(${mod.name}${mod.qty > 1 ? ' x'+mod.qty : ''})</small></div>`
            ).join('') + '</div>' : '';

        const modsTotal = item.modifiers ? item.modifiers.reduce((s, m) => s + (m.price * (m.qty||1)), 0) : 0;
        const linePrice = (item.base_price + modsTotal) * item.qty;
        total += linePrice;

        body += `
        <div class="order-list-row" data-idx="${idx}">
            <div class="order-list-col order-list-col-item">
                ${item.name}
                ${mods}
            </div>
            <div class="order-list-col order-list-col-qty">${item.qty}</div>
            <div class="order-list-col order-list-col-price">${formatRupiah(linePrice)}</div>
            <button class="remove-order-btn" data-idx="${idx}" title="Remove order" style="margin-left:8px; background:transparent; border:none; color:#b91c1c; cursor:pointer; font-size:20px;">&times;</button>
        </div>`;
    });

    orderListDiv.innerHTML = `
        <div class="order-list-styled">
            <hr>
            <div class="order-list-header" style="display:flex;align-items:center;">
                <span class="order-list-col order-list-col-item">Item</span>
                <span class="order-list-col order-list-col-qty">Qty</span>
                <span class="order-list-col order-list-col-price">Subtotal</span>
                <button id="removeAllOrdersBtn" title="Remove All Orders" style="margin-left:auto;background:#fbeaea;border:1px solid #e0baba;border-radius:4px;color:#b91c1c;cursor:pointer;padding:4px 10px;font-size:0.95em;">x</button>
            </div>
            <div class="order-list-body">
                ${body}
            </div>
            <hr>
            <div class="order-list-total-row">
                <span class="order-list-total-label">Total</span>
                <span class="order-list-total-value">${formatRupiah(total)}</span>
            </div>
        </div>
    `;

    // Attach remove one handlers
    orderListDiv.querySelectorAll('.remove-order-btn').forEach(btn => {
        btn.onclick = function() {
            const idx = parseInt(this.getAttribute('data-idx'));
            cart.splice(idx, 1);
            renderOrderList();
        }
    });

    // Attach remove all handler
    const removeAllBtn = orderListDiv.querySelector('#removeAllOrdersBtn');
    if (removeAllBtn) {
        removeAllBtn.onclick = function() {
            cart = [];
            renderOrderList();
        }
    }
}
document.querySelector('.confirm-order-btn').addEventListener('click', function() {
    if (!cart.length) {
        alert("No products in cart.");
        return;
    }
    // Prepare order payload
    const items = cart.map(item => ({
        product_id: item.product_id,
        qty: item.qty,
        subtotal: item.base_price,
        modifiers: (item.modifiers || []).map(mod => ({
            id: mod.id,
            price: mod.price,
            qty: mod.qty || 1
        }))
    }));

    fetch('{{ route('orders.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ items })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            cart = [];
            renderOrderList();
            // Redirect to Orders page
            window.location.href = "{{ route('orders.index') }}";
        } else {
            alert('Order failed.');
        }
    })
    .catch(() => alert('Order failed.'));
});
        </script>
</body>
</html>