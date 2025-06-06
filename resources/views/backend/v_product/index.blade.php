{{-- PRODUCT INDEX --}}
<x-backend.layoutDash>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(!session('active_store_id'))
                        <div class="alert alert-warning mt-3">You must activate a store to view products.</div>
                    @elseif($products->isEmpty())
                        <div class="text-center my-5">
                            <h4>You haven't registered any product yet.</h4>
                            <a href="{{ route('backend.product.create') }}" class="btn btn-lg btn-success mt-3">Register Your First Product</a>
                        </div>
                    @else
                        <h5 class="card-title">{{ $title ?? 'Product' }}<br><br>
                            <a href="{{ route('backend.product.create') }}" class="btn btn-outline-primary">Add Product</a>
                        </h5>
                        <div class="row">
                            @foreach($products as $item)
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow" style="background: url('{{ asset('storage/img-product/' . ($item->menu_image ?? 'default.png')) }}') no-repeat center center; background-size: contain; min-height: 210px; position:relative;">
                                        <div class="card-body bg-dark bg-opacity-75" style="position: absolute; bottom: 0; width: 100%; color: #ffffff;">
                                            <h5 class="card-title">{{ $item->product_name }}</h5>
                                            <h5 class="card-title">{{ $item->categories->category_name ?? $item->category_id }}</h5>
                                            <h5 class="card-title">Rp{{ $item->product_price }}</h5>
                                            <h5 class="card-title">
                                                {!! $item->is_available ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}
                                            </h5>
                                            <div class="d-flex align-items-center gap-2">
                                                {{-- Edit Button --}}
                                                <a href="{{ route('backend.product.edit', $item->product_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                
                                                {{-- Add Modifier Button --}}
                                                <a href="{{ route('backend.product.add_modifier', $item->product_id) }}" class="btn btn-info btn-sm">Modifier</a>
                                            
                                                {{-- NEW: Form for the toggle button --}}
                                                <form action="{{ route('backend.product.toggle', $item->product_id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @if($item->is_available)
                                                        <button type="submit" class="btn btn-secondary btn-sm">Deactivate</button>
                                                    @else
                                                        <button type="submit" class="btn btn-success btn-sm">Activate</button>
                                                    @endif
                                                </form>
                                                <form action="{{ route('backend.product.destroy', $item->product_id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Uncomment if using pagination --}}
                        {{-- <div class="mt-4">
                            {{ $products->links() }}
                        </div> --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-backend.layoutDash>