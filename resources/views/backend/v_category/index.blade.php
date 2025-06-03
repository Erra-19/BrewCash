<x-backend.layoutDash>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            
                @if(!session('active_store_id'))
                    <div class="alert alert-warning mt-3">You must activate a store to view categories.</div>
                @elseif($category->isEmpty())
                    <div class="text-center my-5">
                        <h4>You haven't registered any category yet.</h4>
                        <a href="{{ route('backend.category.create') }}" class="btn btn-lg btn-success mt-3">Register Your First Category</a>
                    </div>
                @else
                    <h5 class="card-title">{{ $title ?? 'Category' }}<br><br>
                        <a href="{{ route('backend.category.create') }}" class="btn btn-outline-primary">Add Category</a>
                    </h5>
                    <div class="row">
                        @foreach($category as $category)
                            <div class="col-md-4 mb-4">
                                <div class="card shadow" style="min-height: 210px; position:relative;">
                                    <div class="card-body bg-dark bg-opacity-75" style="position: absolute; bottom: 0; width: 100%; color: #ffffff;">
                                        <h5 class="card-title">{{ $category->category_name }}</h5>
                                        <div class="d-flex">
                                            <a href="{{ route('backend.category.update', $category->category_id) }}" class="btn btn-warning btn-sm mr-2">Update</a>
                                            <form action="{{ route('backend.category.destroy', $category->category_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" style="display:inline;">
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
                @endif
            </div>
        </div>
    </div>
</div>
</x-backend.layoutDash>