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
                <a href="{{ route('front.dashboard') }}" class="report-btn">Menu</a>
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
    <div class="order-list-wrapper" style="max-width:1200px;margin:0 auto;">
        <div style="display:flex;align-items:center;gap:2rem;margin-bottom:2rem;">
            <h2 style="font-family: 'Rokkit', serif; color: #103E13; margin-bottom:0;">Orders</h2>
            <div id="order-tabs" style="display:flex;gap:1rem;">
                <button class="order-tab-btn active" data-status="Open">Open</button>
                <button class="order-tab-btn" data-status="Paid">Paid</button>
                <button class="order-tab-btn" data-status="Cancelled">Cancelled</button>
            </div>
        </div>
        <div id="orders-content">
            <!-- Orders grid will be loaded here via AJAX -->
        </div>
    </div>
    <script>
        // Helper: find order total in .order-total or fallback selector
        function getOrderTotal(form) {
            let totalEl = form.closest('.order-card').querySelector('.order-total');
            if (!totalEl) {
                totalEl = form.closest('.order-card').querySelector('span[style*="font-weight:600;"]');
            }
            if (!totalEl) return 0;
            return parseInt(totalEl.textContent.replace(/[^0-9]/g, '')) || 0;
        }

        function setPaymentFormReadOnly(form, isReadOnly = true) {
            form.querySelectorAll('input, select, button[type="submit"]').forEach(el => {
                if (isReadOnly) {
                    el.setAttribute('disabled', 'disabled');
                } else {
                    el.removeAttribute('disabled');
                }
            });
            // Always keep close/cancel buttons enabled
            form.querySelectorAll('.close-details-btn, .cancel-order-btn').forEach(el => {
                el.removeAttribute('disabled');
            });
        }

        function bindOrderCardEvents() {
            document.querySelectorAll('.view-details-btn').forEach(btn => {
                btn.onclick = function() {
                    const orderId = this.getAttribute('data-order-id');
                    const details = document.getElementById('details-' + orderId);
                    document.querySelectorAll('.order-details-expand').forEach(el => {
                        if (el !== details) el.style.display = 'none';
                    });
                    details.style.display = (details.style.display === 'none' || !details.style.display) ? 'block' : 'none';
                };
            });

            document.querySelectorAll('.close-details-btn').forEach(btn => {
                btn.onclick = function() {
                    this.closest('.order-details-expand').style.display = 'none';
                };
            });

            document.querySelectorAll('.payment-form').forEach(form => {
                const paidInput = form.querySelector('input[name="paid_amount"]');
                const changeInput = form.querySelector('input[name="change"]');
                const methodSelect = form.querySelector('select[name="payment_method"]');
                const total = getOrderTotal(form);

                function updateChange() {
                    const paid = parseInt(paidInput.value) || 0;
                    const method = methodSelect.value;
                    if (method === 'Cash') {
                        let change = paid - total;
                        if (change < 0) change = 0;
                        changeInput.value = 'Rp' + change.toLocaleString('id-ID');
                    } else {
                        paidInput.value = total;
                        changeInput.value = 'Rp0';
                    }
                }

                if (paidInput && changeInput && methodSelect) {
                    paidInput.addEventListener('input', updateChange);
                    methodSelect.addEventListener('change', function() {
                        if (this.value !== 'Cash') {
                            paidInput.value = total;
                            changeInput.value = 'Rp0';
                            paidInput.setAttribute('readonly', 'readonly');
                        } else {
                            paidInput.removeAttribute('readonly');
                            updateChange();
                        }
                    });
                    if (methodSelect.value !== 'Cash') {
                        paidInput.value = total;
                        changeInput.value = 'Rp0';
                        paidInput.setAttribute('readonly', 'readonly');
                    } else {
                        paidInput.removeAttribute('readonly');
                        updateChange();
                    }
                }

                // Confirm Payment
                let confirmBtn = form.querySelector('.confirm-payment-btn');
                if (confirmBtn) {
                    confirmBtn.onclick = function(e) {
                        e.preventDefault();
                        const orderId = form.dataset.orderId;
                        const paidAmount = paidInput.value;
                        const paymentMethod = methodSelect.value;
                        fetch(`/orders/${orderId}/pay`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                payment_method: paymentMethod,
                                paid_amount: paidAmount
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                setPaymentFormReadOnly(form, true);
                                confirmBtn.textContent = 'Paid';
                                confirmBtn.setAttribute('disabled', 'disabled');
                                // Optionally update status label in card to "Paid"
                                form.closest('.order-card').querySelector('.order-status').textContent = 'Paid';
                                form.closest('.order-card').querySelector('.order-status').classList.remove('Open');
                                form.closest('.order-card').querySelector('.order-status').classList.add('Paid');
                            } else {
                                alert(data.error || 'Failed to update payment.');
                            }
                        });
                    };
                }

                // Cancel Order
                let cancelBtn = form.querySelector('.cancel-order-btn');
                if (cancelBtn) {
                    cancelBtn.onclick = function(e) {
                        e.preventDefault();
                        if (!confirm('Cancel this order?')) return;
                        const orderId = form.dataset.orderId;
                        fetch(`/orders/${orderId}/cancel`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                setPaymentFormReadOnly(form, true);
                                // Optionally update status label in card to "Cancelled"
                                form.closest('.order-card').querySelector('.order-status').textContent = 'Cancelled';
                                form.closest('.order-card').querySelector('.order-status').classList.remove('Open');
                                form.closest('.order-card').querySelector('.order-status').classList.add('Cancelled');
                            } else {
                                alert(data.error || 'Failed to cancel order.');
                            }
                        });
                    };
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            function loadOrders(status) {
                const content = document.getElementById('orders-content');
                fetch("{{ route('orders.ajax') }}?status=" + encodeURIComponent(status))
                    .then(res => res.text())
                    .then(html => {
                        content.innerHTML = html;
                        bindOrderCardEvents();
                    });
            }

            // Initial load
            loadOrders('Open');

            document.querySelectorAll('.order-tab-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.order-tab-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    loadOrders(this.getAttribute('data-status'));
                });
            });

            bindOrderCardEvents();
        });
    </script>
</body>
</html>