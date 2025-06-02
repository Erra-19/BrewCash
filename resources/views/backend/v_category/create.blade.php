<x-backend.layoutDash>
<div class="col-md-12">
    <div class="card">
        <form class="form-horizontal" action="{{ route('backend.category.store') }}" method="post">
            @csrf

            <div class="card-body">
                <h4 class="card-title">{{$title}}</h4>

                <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" name="category_name" class="form-control @error('category_name') is-invalid @enderror" placeholder="Insert Your Category Name">
                    @error('category_name')
                    <span class="invalid-feedback alert-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

            </div>
            <div class="border-top">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('backend.category.index') }}">
                        <button type="button" class="btn btn-secondary">Return</button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
</x-backend.layoutDash>