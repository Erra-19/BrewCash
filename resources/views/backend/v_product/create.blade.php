<x-backend.layoutDash>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form class="form-horizontal" action="{{ route('backend.product.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
    
                        <div class="card-body">
                            <h4 class="card-title"> {{$title}} </h4>
                            <div class="row">
    
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Choose Your Product Image</label>
                                        <img class="previewpicture">
                                        <input type="file" name="product_image" class="form-control @error('product_image') is-invalid @enderror" onchange="previewpicture()">
                                        @error('product_image')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror" placeholder="Insert Your Product Name">
                                        @error('product_name')
                                        <span class="invalid-feedback alert-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Product Category</label>
                                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">-- Choose Category --</option>
                                            @foreach($category as $cat)
                                                <option value="{{ $cat->category_id }}" {{ old('category_id') == $cat->category_id ? 'selected' : '' }}>
                                                    {{ $cat->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="invalid-feedback alert-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>product Price</label>
                                        <input type="text" name="product_price" class="form-control @error('product_price') is-invalid @enderror" placeholder="Insert Your Product Price">
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
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('backend.product.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-backend.layoutDash>