<x-backend.layoutDash>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('backend.modifier.update', $edit->mod_id) }}" method="post" enctype="multipart/form-data">
                        @method('put')
                        @csrf

                        <div class="card-body">
                            <h4 class="card-title"> {{ $title ?? 'Edit Modifier Item' }} </h4>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Modifier Image</label>
                                        @if ($edit->mod_image)
                                            <img src="{{ asset('storage/img-modifiers/' . $edit->mod_image) }}" class="previewPicture" width="100%">
                                            <p></p>
                                        @else
                                            <img src="{{ asset('storage/img-modifiers/deficon.png') }}" class="previewPicture" width="100%">
                                            <p></p>
                                        @endif
                                        
                                        <input type="file" name="mod_image" class="form-control @error('mod_image') is-invalid @enderror" onchange="previewPicture()">
                                        
                                        {{-- ADJUSTMENT: Made the error message more robust and visible --}}
                                        @error('mod_image')
                                            <div class="mt-1" style="color: #dc3545; font-size: 80%;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="mod_name">Modifier Name</label>
                                        <input type="text" name="mod_name" id="mod_name" value="{{ old('mod_name', $edit->mod_name) }}" class="form-control @error('mod_name') is-invalid @enderror" placeholder="Enter Modifier Name">
                                        @error('mod_name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-top">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary">Update Modifier</button>
                                <a href="{{ route('backend.modifier.index') }}"class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-backend.layoutDash>