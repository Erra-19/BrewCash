<x-backend.layoutDash>
<div class="container">
    <h2 class="mb-4">Logs / Reports</h2>
    <form method="get" class="mb-3">
        <div style="display:flex; flex-wrap:wrap; gap:1rem;">
            <input type="text" name="action" value="{{ request('action') }}" placeholder="Action" class="form-control" style="width:150px;">
            <select name="type" class="form-control" style="width:120px;">
                <option value="">All Types</option>
                <option value="order" {{ request('type')=='order'?'selected':'' }}>Order</option>
                <option value="login" {{ request('type')=='login'?'selected':'' }}>Login</option>
                <option value="payment" {{ request('type')=='payment'?'selected':'' }}>Payment</option>
                <!-- add more as needed -->
            </select>
            <select name="user_id" class="form-control" style="width:180px;">
                <option value="">All Users</option>
                @foreach($users as $user)
                <option value="{{ $user->user_id }}"{{ request('user_id')==$user->user_id?' selected':'' }}>{{ $user->name }}</option>
                @endforeach
            </select>
            <select name="store_id" class="form-control" style="width:180px;">
                <option value="">All Stores</option>
                @foreach($stores as $store)
                <option value="{{ $store->store_id }}"{{ request('store_id')==$store->store_id?' selected':'' }}>{{ $store->store_name }}</option>
                @endforeach
            </select>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" style="width:140px;">
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" style="width:140px;">
            <button type="submit" class="btn btn-primary">Filter</button>
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
</div>
</x-backend.layoutDash>