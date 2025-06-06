<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Log Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        pre {
            white-space: pre-wrap;
            font-size: 11px;
            margin: 0;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Log Report</h1>
        <p>
            Generated on: {{ now()->format('Y-m-d H:i:s') }} <br>
            @if(!empty($filters['start_date']) || !empty($filters['end_date']))
                <strong>Period:</strong> {{ $filters['start_date'] ?? '...' }} to {{ $filters['end_date'] ?? '...' }}
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Time</th>
                <th>User</th>
                <th>Store</th>
                <th>Type</th>
                <th>Action</th>
                <th>Meta</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $log->user->name ?? 'N/A' }}</td>
                <td>{{ $log->store->store_name ?? 'N/A' }}</td>
                <td>{{ $log->type }}</td>
                <td>{{ $log->action }}</td>
                <td>
                    @if(is_array($log->meta))
                        <pre>{{ json_encode($log->meta, JSON_PRETTY_PRINT) }}</pre>
                    @else
                        {{ $log->meta }}
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No logs found for the selected filters.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>