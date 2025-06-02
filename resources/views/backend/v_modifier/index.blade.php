<x-backend.layoutDash>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($modifier->isEmpty())
                        <div class="text-center my-5">
                            <h4>You Don't Have Any Modifier Yet.</h4>
                            <a href="{{ route('backend.modifier.create') }}" class="btn btn-lg btn-success mt-3">Register Your First Modifier</a>
                        </div>
                    @else
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">{{ $title ?? 'Modifier' }}</h5>
                            <a href="{{ route('backend.modifier.create') }}" class="btn btn-outline-primary">Add Modifier</a>
                        </div>
                        <div class="row">
                            @foreach($modifier as $item)
                                <div class="col-md-4 mb-4">
                                    <div class="card shadow" style="background: url('{{ asset('storage/img-modifiers/' . ($item->mod_image ?? 'default.png')) }}') no-repeat center center; background-size: contain; min-height: 210px; position:relative;">
                                        <div class="card-body bg-dark bg-opacity-75" style="position: absolute; bottom: 0; width: 100%; color: #ffffff;">
                                            <h5 class="card-title">{{ $item->mod_id }}</h5>
                                            <h5 class="card-title">{{ $item->mod_name }}</h5>
                                            <h5 class="card-title">{{ $item->Categories->category_name ?? $item->category_id }}</h5>
                                            <h5 class="card-title">
                                                {!! $item->is_available ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' !!}
                                            </h5>
                                            <div class="d-flex">
                                                <a href="{{ route('backend.modifier.edit', $item->mod_id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                                                <form action="{{ route('backend.modifier.destroy', $item->mod_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Modifier?');" style="display:inline;">
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
                            {{ $modifier->links() }}
                        </div> --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
    </x-backend.layoutDash>