<x-backend.layoutDash>
<div class="col-md-12">
    <div class="card">
        <form class="form-horizontal" action="{{ route('backend.category.update', $edit->category_id) }}" method="post">
            @method('put')
            @csrf
            <div class="card-body">
                <h4 class="card-title">{{$title}}</h4>

                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" name="category_name" value="{{ old('category_name',$edit->category_name) }}" class="form-control @error('category_name') is-invalid @enderror" placeholder="Insert Your Category Name">
                    @error('category_name')
                    <span class="invalid-feedback alert-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

            </div>
            <div class="border-top">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('backend.category.index') }}" class="btn btn-secondary">Return</a>
                </div>
            </div>
        </form>
    </div>
</div>
</x-backend.layoutDash>