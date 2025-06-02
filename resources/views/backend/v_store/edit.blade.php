<x-backend.layoutDash>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('backend.store.update', $edit->store_id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf

                    <div class="card-body">
                        <h4 class="card-title"> {{$title}} </h4>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Store Icon</label>
                                    {{-- view image --}}
                                    @if ($edit->store_icon)
                                        <img src="{{ asset('storage/img-store/' . $edit->store_icon) }}" class="previewPicture" width="100%">
                                        <p></p>
                                    @else
                                        <img src="{{ asset('storage/img-store/deficon.png') }}" class="previewPicture" width="100%">
                                        <p></p>
                                    @endif
                                    {{-- file store_icon --}}
                                    <input type="file" name="store_icon" class="form-control @error('store_icon') is-invalid @enderror" onchange="previewPicture()">
                                    @error('store_icon')
                                        <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Store Name</label>
                                    <input type="text" name="store_name" value="{{ old('store_name',$edit->store_name) }}" class="form-control @error('store_name') is-invalid @enderror" placeholder="Insert Your New Store Name">
                                    @error('store_name')
                                    <span class="invalid-feedback alert-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Store Address</label><br>
                                    <textarea name="store_address" class="form-control @error('store_address') is-invalid @enderror" id="ckeditor">{{ old('store_address',$edit->store_address) }}</textarea>
                                    @error('store_address')
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
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('backend.store.index') }}" class="btn btn-secondary">Return</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-backend.layoutDash>