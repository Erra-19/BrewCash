<x-backend.layoutDash>
    <div class="col-md-12">
        <div class="card">
            <form class="form-horizontal" action="{{ route('backend.staff.update', [$store->store_id, $staffs->user_id]) }}" method="post">
                @csrf
                @method('PUT')
    
                <div class="card-body">
                    <h4 class="card-title">{{ $title ?? 'Edit staffs' }}</h4>
    
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name', $staffs->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama">
                        @error('name')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" value="{{ old('email', $staffs->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email">
                        @error('email')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        <label>phone number</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $staffs->phone_number) }}" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Masukkan No HP">
                        @error('phone_number')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        <label>Role in this store</label>
                        <input type="text" name="store_role" value="{{ old('store_role', $staffs->pivot->store_role) }}" class="form-control @error('store_role') is-invalid @enderror" placeholder="Contoh: Kasir, Admin, Supervisor">
                        @error('store_role')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="1" {{ old('status', $staffs->pivot->status, ) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $staffs->pivot->status, ) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback alert-danger" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
    
                </div>
                <div class="border-top">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('backend.staff.index', $store->store_id) }}">
                            <button type="button" class="btn btn-secondary">Return</button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </x-backend.layoutDash>