<x-backend.layoutDash>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="form-horizontal" action="{{ route('backend.store.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <h4 class="card-title"> {{$title}} </h4>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Choose Your Icon</label>
                                    <img class="foto-preview">
                                    <input type="file" name="store_icon" class="form-control @error('store_icon') is-invalid @enderror" onchange="previewpicture()">
                                    @error('store_icon')
                                    <div class="invalid-feedback alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Store Name</label>
                                    <input type="text" name="store_name" class="form-control @error('store_name') is-invalid @enderror" placeholder="Insert your store name">
                                    @error('store_name')
                                    <span class="invalid-feedback alert-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Store Address</label><br>
                                    <textarea name="store_address" class="form-control @error('store_address') is-invalid @enderror" id="ckeditor"></textarea>
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
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('backend.store.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-backend.layoutDash>