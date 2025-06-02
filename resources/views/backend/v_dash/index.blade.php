<x-backend.layoutDash>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body border-top">
                <h5 class="card-title"> {{$title}}</h5>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading"> Wellcome, {{ Auth::user()->name }}</h4>
                    BrewCash - Your personal store management
                    <b>
                        @if (Auth::user()->role == 'Owner')
                        Owner
                        @else
                        Admin
                        @endif
                    </b>
                    this is your dashboard.
                    <hr>
                    <p class="mb-0">BrewCash</p>
                </div>
                <div class="row">
                    @foreach($stores as $store)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow" style="background: url('{{ asset('storage/img-store/' . ($store->store_icon ?? 'default.png')) }}') no-repeat; background-size: contain; min-height: 210px; position:relative; background-color: transparent !important;">
                                <div class="card-body bg-dark bg-opacity-75" style="position: absolute; bottom: 0; width: 100%; color: #ffffff;">
                                    <h5 class="card-title">{{ $store->store_name }}</h5>
                                    <p class="card-text">{{ $store->store_address }}</p>
                                    <div class="d-flex">
                                        <a href="{{ route('backend.store.show', $store->store_id) }}" class="btn btn-warning btn-sm mr-2">View Detail</a>
                                        <a href="{{ route('backend.store.edit', $store->store_id) }}" class="btn btn-warning btn-sm mr-2">Update</a>
                                        <form action="{{ route('backend.store.destroy', $store->store_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this store?');" style="display:inline;">
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
            </div>
        </div>
    </div>
</div>
</x-backend.layoutDash>