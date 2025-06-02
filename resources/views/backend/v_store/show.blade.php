<x-backend.layoutDash>
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                {{-- Store Icon --}}
                @if($store->store_icon)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/img-store/' . $store->store_icon) }}" alt="{{$store->store_name}}" class="img-fluid rounded" style="max-width:120px;">
                    </div>
                @endif

                {{-- Store Details --}}
                <h2>{{ $store->store_name }}</h2>
                <p class="mb-1">
                    <strong>Address:</strong> {{ $store->store_address }}
                </p>

                <hr>

                {{-- Staff List Preview --}}
                <h4>Registered Staff</h4>
                @if($store->staffs->count() > 0)
                    <ul class="list-group mb-3">
                        @foreach($store->staffs->take(5) as $staff)
                            <li class="list-group-item d-flex align-items-center justify-content-between">
                                <div>
                                    <strong>{{ $staff->name }}</strong>
                                    <span class="badge bg-secondary ms-2">{{ $staff->pivot->role }}</span>
                                </div>
                                <span class="text-muted">{{ $staff->email }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-info">
                        No staff registered to this store yet.
                    </div>
                @endif

                <div class="d-flex gap-2">
                    {{-- <a href="{{ route('backend.staff.index', $store->store_id) }}" class="btn btn-outline-primary">
                        View All Staff
                    </a> --}}
                    <a href="{{ route('backend.staff.index', $store->store_id) }}" class="btn btn-outline-primary">
                        View All Staff
                    </a>
                    <a href="{{ route('backend.staff.create', $store->store_id) }}" class="btn btn-success">
                        Register New Staff
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-backend.layoutDash>