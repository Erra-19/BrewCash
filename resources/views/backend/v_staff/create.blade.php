<x-backend.layoutDash>
    <div class="col-md-12">
        <div class="card">
            <form class="form-horizontal" action="{{ route('backend.staff.store', $store->store_id) }}" method="post">
                @csrf
    
                <div class="card-body">
                    <h4 class="card-title">Register Staff for {{ $store->store_name }}</h4>
    
                    {{-- Staff Name --}}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Insert Staff Name">
                        @error('name')
                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
    
                    {{-- Email --}}
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Insert Staff Email">
                        @error('email')
                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
    
                    {{-- Phone Number --}}
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Insert Phone Number">
                        @error('phone_number')
                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
    
                    {{-- Custom Role for This Store --}}
                    <div class="form-group">
                        <label>Role in this store</label>
                        <input type="text" name="store_role" value="{{ old('store_role') }}" class="form-control @error('store_role') is-invalid @enderror" placeholder="e.g., Cashier, Barista, Manager">
                        @error('store_role')
                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
    
                    {{-- Password --}}
                    <div class="form-group">
                        <label>Password <small class="text-muted">(Optional, leave blank for default)</small></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Insert Password or leave blank">
                        @error('password')
                        <span class="invalid-feedback alert-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
    
                    {{-- Password Confirmation --}}
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                    </div>
                </div>
                <div class="border-top">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('backend.store.show', $store->store_id) }}"class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-backend.layoutDash>