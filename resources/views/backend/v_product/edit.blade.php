<x-backend.layoutDash>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('backend.product.update', $edit->product_id) }}" method="post" enctype="multipart/form-data">
                        @method('put')
                        @csrf

                        <div class="card-body">
                            <h4 class="card-title"> {{ $title ?? 'Edit product Item' }} </h4>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>product Image</label>
                                        {{-- view image --}}
                                        @if ($edit->product_image)
                                            <img src="{{ asset('storage/img-product/' . $edit->product_image) }}" class="previewPicture" width="100%">
                                            <p></p>
                                        @else
                                            <img src="{{ asset('storage/img-product/deficon.png') }}" class="previewPicture" width="100%">
                                            <p></p>
                                        @endif
                                        {{-- file product_image --}}
                                        <input type="file" name="product_image" class="form-control @error('product_image') is-invalid @enderror" onchange="previewPicture()">
                                        @error('product_image')
                                            <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="product_id">product ID</label>
                                        <input type="text" name="product_id" value="{{ old('product_id', $edit->product_id) }}" class="form-control">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="product_name">product Name</label>
                                        <input type="text" name="product_name" id="product_name" value="{{ old('product_name', $edit->product_name) }}" class="form-control @error('product_name') is-invalid @enderror" placeholder="Enter product Name">
                                        @error('product_name')
                                        <span class="invalid-feedback alert-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="product_price">product Price</label>
                                        <input type="text" name="product_price" id="product_price" value="{{ old('product_price', $edit->product_price) }}" class="form-control @error('product_price') is-invalid @enderror" placeholder="Enter product Price (e.g., 50000)">
                                        @error('product_price')
                                        <span class="invalid-feedback alert-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                                <a href="{{ route('backend.product.index') }}"class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-backend.layoutDash>