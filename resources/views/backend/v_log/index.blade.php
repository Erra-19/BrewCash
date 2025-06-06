<x-backend.layoutDash>
<div class="container">
    <h2 class="mb-4">Logs / Reports</h2>
    @if($requires_store ?? false)
        <div class="alert alert-warning text-center">
            <h4 class="alert-heading">No Active Store</h4>
            <p>You must activate a store to view its activity report.</p>
            <hr>
            <a href="{{ route('backend.store.index') }}" class="btn btn-primary">Go to My Stores</a>
        </div>
    @else
    <form method="get" class="mb-3">
        <div style="display:flex; flex-wrap:wrap; gap:0.75rem; align-items:center;">
            <div class="flex-grow-1" style="min-width: 150px;">
                <input type="text" name="action" value="{{ request('action') }}" placeholder="Action Contains..." class="form-control">
            </div>
            <div class="flex-grow-1" style="min-width: 150px;">
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="Authentication" {{ request('type') == 'Authentication' ? 'selected' : '' }}>Authentication</option>
                    <option value="Staff" {{ request('type') == 'Staff' ? 'selected' : '' }}>Staff Management</option>
                    <option value="Product" {{ request('type') == 'Product' ? 'selected' : '' }}>Products</option>
                    <option value="Modifier" {{ request('type') == 'Modifier' ? 'selected' : '' }}>Modifiers</option>
                    <option value="Category" {{ request('type') == 'Category' ? 'selected' : '' }}>Categories</option>
                    <option value="Order" {{ request('type') == 'Order' ? 'selected' : '' }}>Orders</option>
                </select>
            </div>
            <div class="flex-grow-1" style="min-width: 180px;">
                <select name="user_id" class="form-select">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->user_id }}"{{ request('user_id') == $user->user_id ? ' selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-grow-1" style="min-width: 150px;">
                <select name="store_role" class="form-select">
                    <option value="">All Roles</option>
                    @foreach($storeRoles as $role)
                        <option value="{{ $role }}" {{ request('store_role') == $role ? 'selected' : '' }}>
                            {{ $role }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-grow-1" style="min-width: 140px;">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" title="Start Date">
            </div>
            <div class="flex-grow-1" style="min-width: 140px;">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" title="End Date">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <button type="submit" name="print" value="1" class="btn btn-success" title="Download as PDF">
                <i class="fas fa-file-pdf"></i>
            </button>
            <a href="{{ route('backend.logs.index') }}" class="btn btn-secondary" title="Reset Filters">
                <i class="fas fa-sync-alt"></i>
            </a>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Report ID</th>
                    <th>User</th>
                    <th>Store</th>
                    <th>Order</th>
                    <th>Type</th>
                    <th>Action</th>
                    <th>Meta</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $log->report_id }}</td>
                    <td>{{ $log->user->name ?? $log->user_id }}</td>
                    <td>{{ $log->store->store_name ?? $log->store_id }}</td>
                    <td>{{ $log->order_id }}</td>
                    <td>{{ $log->type }}</td>
                    <td>{{ $log->action }}</td>
                    <td>
                        @if(is_array($log->meta))
                            <pre style="white-space:pre-wrap;font-size:0.93em;">{{ json_encode($log->meta, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                        @else
                            {{ $log->meta }}
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No logs found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $logs->links() }}
    @endif
</div>
</x-backend.layoutDash>