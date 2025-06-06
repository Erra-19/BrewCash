<x-backend.layoutDash>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form class="form-horizontal" action="{{ route('backend.modifier.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
    
                        <div class="card-body">
                            <h4 class="card-title"> {{$title}} </h4>
                            <div class="row">
    
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Choose Your Modifier Image</label>
                                        
                                        {{-- ADJUSTMENT 1: Added a default image source and corrected class name for consistency --}}
                                        <img src="{{ asset('storage/img-modifiers/deficon.png') }}" class="previewPicture" width="100%">
                                        <p></p> {{-- Added for spacing --}}
                                        
                                        <input type="file" name="mod_image" class="form-control @error('mod_image') is-invalid @enderror" onchange="previewPicture()">
                                        
                                        {{-- ADJUSTMENT 2: Made the error message more robust and visible --}}
                                        @error('mod_image')
                                            <div class="mt-1" style="color: #dc3545; font-size: 80%;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Modifier Name</label>
                                        <input type="text" name="mod_name" value="{{ old('mod_name') }}" class="form-control @error('mod_name') is-invalid @enderror" placeholder="Insert Your Modifier Name">
                                        @error('mod_name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Modifier Category</label>
                                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">-- Choose Category --</option>
                                            @foreach($category as $cat)
                                                <option value="{{ $cat->category_id }}" {{ old('category_id') == $cat->category_id ? 'selected' : '' }}>
                                                    {{ $cat->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
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
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('backend.modifier.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-backend.layoutDash>