<x-backend.layoutDash>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
    
                    <h5 class="card-title">{{ $title ?? 'Daftar staffs' }} <br><br>
                        <a href="{{ route('backend.staff.create', $store->store_id) }}">
                            <button type="button" class="btn btn-outline-primary">Add staffs</button>
                        </a>
                    </h5>
    
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>staffs Name</th>
                                    <th>Role in this store</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($staffList as $staffs)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $staffs->user_id }}</td>
                                    <td>{{ $staffs->email }}</td>
                                    <td>{{ $staffs->name }}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $staffs->pivot->store_role }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($staffs->pivot->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Edit staffs, scoped to this store --}}
                                        <a href="{{ route('backend.staff.edit', [$store->store_id, $staffs->user_id]) }}" title="Ubah Data"
                                            class="btn btn-cyan btn-sm"><i class="far fa-edit"></i> Update</a>
                                        <form method="POST" action="{{ route('backend.staff.destroy', [$store->store_id, $staffs->user_id]) }}" style="display: inline-block;">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data" onclick="return confirm('Yakin ingin menghapus staffs ini dari toko?')">
                                                <i class="fas fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No staffs Registered In This Store Yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
    
                </div>
            </div>
        </div>
    </div>
    </x-backend.layoutDash>