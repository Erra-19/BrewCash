<x-backend.layoutDash>
    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($stores->isEmpty() && Auth::user()->isOwner())
            <div class="text-center my-5">
                <h4>You haven't registered any stores yet.</h4>
                <a href="{{ route('backend.store.create') }}" class="btn btn-lg btn-success mt-3">Register Your First Store</a>
            </div>
        @else
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>{{ $title ?? 'Store' }}</h2>
                {{-- Show "Register Store" button ONLY to Owners --}}
                @if (Auth::user()->isOwner())
                    <a href="{{ route('backend.store.create') }}" class="btn btn-primary">Register Store</a>
                @endif
            </div>
            <div class="row">
                @foreach($stores as $store)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow" style="background: url('{{ asset('storage/img-store/' . ($store->store_icon ?? 'default.png')) }}') no-repeat; background-size: contain; min-height: 210px; position:relative; background-color: transparent !important;">
                            <div class="card-body bg-dark bg-opacity-75" style="position: absolute; bottom: 0; width: 100%; color: #ffffff;">
                                <h5 class="card-title">{{ $store->store_name }}</h5>
                                <p class="card-text">{{ $store->store_address }}</p>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('backend.store.show', $store->store_id) }}" class="btn btn-warning btn-sm">View Detail</a>
                                    @if (Auth::user()->isOwner())
                                        <a href="{{ route('backend.store.edit', $store->store_id) }}" class="btn btn-warning btn-sm">Update</a>
                                    @endif
                                    @if (Auth::user()->isOwner())
                                        <form action="{{ route('backend.store.destroy', $store->store_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this store?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    @endif

                                    @php
                                        $activeStoreId = session('active_store_id');
                                    @endphp
                                    
                                    {{-- "Activate" button is ONLY for Owners --}}
                                    @if (Auth::user()->isOwner())
                                        @if($activeStoreId !== $store->store_id)
                                            <form method="POST" action="{{ route('backend.store.activate', $store->store_id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Activate</button>
                                            </form>
                                        @else
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    @else
                                        {{-- Staff will see the active badge but cannot change it from this screen --}}
                                        @if($activeStoreId === $store->store_id)
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-backend.layoutDash>