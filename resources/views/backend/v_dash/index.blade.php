<x-backend.layoutDash>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body border-top">
                    <h5 class="card-title"> {{$title}}</h5>
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading"> Wellcome, {{ Auth::user()->name }}</h4>
                        BrewCash - Your personal store management
                        <b>
                            @php
                                $user = Auth::user();
                                $displayRole = '';
    
                                if ($user->isOwner()) {
                                    $displayRole = 'Owner';
                                }
                                elseif ($user->isStaff()) {
                                    $activeStoreId = session('active_store_id');
                                    if ($activeStoreId) {
                                        $storeAssignment = $user->staffs->firstWhere('store_id', $activeStoreId);
                                        $displayRole = $storeAssignment ? $storeAssignment->pivot->store_role : 'Staff';
                                    } else {
                                        $displayRole = 'Staff';
                                    }
                                }
                            @endphp
                            {{ $displayRole }}
                        </b>
                        this is your dashboard.
                        <hr>
                        <p class="mb-0">BrewCash</p>
                    </div>
    
                    {{-- Row for Store Card & Recent Activity --}}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                @foreach($stores as $store)
                                    <div class="col-md-12 mb-4">
                                        {{-- Your Store Card HTML --}}
                                        <div class="card shadow" style="background: url('{{ asset('storage/img-store/' . ($store->store_icon ?? 'default.png')) }}') no-repeat; background-size: contain; min-height: 210px; position:relative; background-color: transparent !important;">
                                            <div class="card-body bg-dark bg-opacity-75" style="position: absolute; bottom: 0; width: 100%; color: #ffffff;">
                                                <h5 class="card-title">{{ $store->store_name }}</h5>
                                                <p class="card-text">{{ $store->store_address }}</p>
                                                {{-- Store buttons... --}}
                                                <div class="d-flex">
                                                    <a href="{{ route('backend.store.show', $store->store_id) }}" class="btn btn-warning btn-sm mr-2">View Detail</a>
                                                    @if (Auth::user()->isOwner())
                                                        <a href="{{ route('backend.store.edit', $store->store_id) }}" class="btn btn-warning btn-sm">Update</a>
                                                        <form action="{{ route('backend.store.destroy', $store->store_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this store?');" style="display:inline;"> @csrf @method('DELETE') <button type="submit" class="btn btn-danger btn-sm">Delete</button></form>
                                                        @if(session('active_store_id') !== $store->store_id)
                                                            <form method="POST" action="{{ route('backend.store.activate', $store->store_id) }}"> @csrf <button type="submit" class="btn btn-success btn-sm">Activate</button></form>
                                                        @else
                                                            <span class="badge bg-success">Active</span>
                                                        @endif
                                                    @elseif(session('active_store_id') === $store->store_id)
                                                        <span class="badge bg-success">Active</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-7">
                           {{-- Your Recent Activity Card HTML --}}
                           <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Recent Activity</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped">
                                            <thead><tr><th>Time</th><th>Report ID</th><th>Type</th><th>Action</th></tr></thead>
                                            <tbody>
                                                @forelse($recentLogs as $log)
                                                <tr><td>{{ $log->created_at->format('H:i:s') }}</td><td>{{ $log->report_id }}</td><td>{{ $log->type }}</td><td>{{ $log->action }}</td></tr>
                                                @empty
                                                <tr><td colspan="4" class="text-center">No recent activity.</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="{{ route('backend.logs.index') }}" class="btn btn-primary btn-sm mt-3">View All Logs</a>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Daily Sales Growth</h5>
    
                                    @if($chartData)
                                        <div class="mb-3">
                                            <button id="showAllSales" class="btn btn-primary btn-sm">All Sales</button>
                                            @foreach($chartData['top_users'] as $user)
                                                <button class="btn btn-outline-secondary btn-sm user-chart-btn" data-user-id="{{ $user['user_id'] }}">
                                                    {{ $user['name'] }}
                                                </button>
                                            @endforeach
                                        </div>
                                        <div style="height: 350px;">
                                            <canvas id="salesChart"></canvas>
                                        </div>
                                    @else
                                        <div class="text-center text-muted p-4" style="height: 350px; display:grid; place-content:center;">
                                            <p>No sales data available to generate a chart.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </div>
    
    {{-- Add Chart.js library --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    {{-- Only run the chart script if there is data to display --}}
    @if($chartData)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartData = @json($chartData);
            const ctx = document.getElementById('salesChart').getContext('2d');
    
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.main.labels,
                    datasets: [{
                        label: 'Total Sales',
                        data: chartData.main.data,
                        borderColor: 'rgb(54, 162, 235)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.1,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
    
            // Function to update the chart with new data
            const updateChart = (label, newData) => {
                salesChart.data.labels = newData.labels;
                salesChart.data.datasets[0].label = label;
                salesChart.data.datasets[0].data = newData.data;
                salesChart.update();
            };
    
            // Event listener for the "All Sales" button
            document.getElementById('showAllSales').addEventListener('click', () => {
                updateChart('Total Sales', chartData.main);
            });
    
            // Event listeners for each user button
            document.querySelectorAll('.user-chart-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const userId = button.getAttribute('data-user-id');
                    const userName = button.textContent.trim();
                    const userData = chartData.user_breakdown[userId];
                    if (userData) {
                        updateChart(`Sales by ${userName}`, userData);
                    }
                });
            });
        });
    </script>
    @endif
    </x-backend.layoutDash>