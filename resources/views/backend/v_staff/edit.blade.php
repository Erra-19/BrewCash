<x-backend.layoutDash>
    <div class="col-md-12">
        <div class="card">
            {{-- Determine if the current user is an admin for this view --}}
            @php
                $isStoreAdmin = Auth::user()->isStaff() && Auth::user()->staffs->find($store->store_id)?->pivot->store_role === 'Admin';
            @endphp

            <form class="form-horizontal" action="{{ route('backend.staff.update', [$store->store_id, $staffs->user_id]) }}" method="post">
                @csrf
                @method('PUT')
        
                <div class="card-body">
                    <h4 class="card-title">{{ $title ?? 'Edit Staff' }}</h4>
                    
                    {{-- Name --}}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name', $staffs->name) }}" class="form-control @error('name') is-invalid @enderror">
                        {{-- ... error message ... --}}
                    </div>
                    
                    {{-- Email (Disabled for Admin) --}}
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" value="{{ old('email', $staffs->email) }}" class="form-control" @if($isStoreAdmin) disabled @endif>
                    </div>
                    
                    {{-- Phone Number --}}
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $staffs->phone_number) }}" class="form-control @error('phone_number') is-invalid @enderror">
                        {{-- ... error message ... --}}
                    </div>
                    
                    {{-- Store Role (Disabled for Admin) --}}
                    <div class="form-group">
                        <label>Role in this store</label>
                        <input type="text" name="store_role" value="{{ old('store_role', $staffs->pivot->store_role) }}" class="form-control" @if($isStoreAdmin) disabled @endif>
                    </div>
                    
                    {{-- Status (Disabled for Admin) --}}
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" @if($isStoreAdmin) disabled @endif>
                            <option value="1" {{ old('status', $staffs->pivot->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $staffs->pivot->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="border-top">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('backend.staff.index', $store->store_id) }}" class="btn btn-secondary">Return</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-backend.layoutDash>