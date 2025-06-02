<x-backend.layoutDash>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($products->isEmpty())
                        <div class="text-center my-5">
                            <h4>You Don't Have Any Product Yet.</h4>
                            <a href="{{ route('backend.product.create') }}" class="btn btn-lg btn-success mt-3">Register Your First Product</a>
                        </div>
                    @else
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">{{ $title ?? 'Product' }}</h5>
                            <a href="{{ route('backend.product.create') }}" class="btn btn-outline-primary">Add Product</a>
                        </div>
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
                                            <div class="d-flex">
                                                <a href="{{ route('backend.product.edit', $item->product_id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                                                <form action="{{ route('backend.product.destroy', $item->product_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                                <a href="{{ route('backend.product.add_modifier', $item->product_id) }}" class="btn btn-info btn-sm me-2">Add Modifier</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Uncomment if using pagination --}}
                        {{-- <div class="mt-4">
                            {{ $product->links() }}
                        </div> --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
    </x-backend.layoutDash>