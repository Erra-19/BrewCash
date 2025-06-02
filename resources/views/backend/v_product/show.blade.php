<x-backend.layoutDash>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$title}}</h4>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" disabled>
                                    <option value="" selected> - Choose Category - </option>
                                    @foreach ($category as $row)
                                    <option value="{{ $row->category_id }}" {{ old('category_id', $show->category_id) == $row->category_id ? 'selected' : '' }}>
                                        {{ $row->category_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_name" value="{{ old('product_name', $show->product_name) }}" class="form-control @error('product_name') is-invalid @enderror" placeholder="Masukkan Nama Produk" disabled>
                                @error('product_name')
                                <span class="invalid-feedback alert-danger" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Foto Utama</label> <br>
                                        <img src="{{ asset('storage/img-produk/' . $show->foto) }}" class="foto-preview" width="100%">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Foto Tambahan</label>
                                <div id="foto-container">
                                    <div class="row">
                                        @foreach($show->fotoProduk as $gambar)
                                        <div class="col-md-8">
                                            <img src="{{ asset('storage/img-produk/' . $gambar->foto) }}" width="100%">
                                        </div>
                                        <div class="col-md-4">
                                            <form action="{{ route('backend.product.destroy', $->product_id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>

                                        @endforeach
                                    </div>

                                    <button type="button" class="btn btn-primary add-foto mt-2">Add Image</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="border-top">
                    <div class="card-body">
                        <a href="{{ route('backend.product.index') }}"class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-backend.layoutDash>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const fotoContainer = document.getElementById('foto-container');
        const addFotoButton = document.querySelector('.add-foto');

        addFotoButton.addEventListener('click', function() {
            const fotoRow = document.createElement('div');
            fotoRow.classList.add('form-group', 'row');
            fotoRow.innerHTML = `
                <form action="{{ route('backend.foto_produk.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        
                        <input type="hidden" name="produk_id" value="{{ $show->id }}">
                        <input type="file" name="foto_produk[]" class="form-control @error('foto_produk') is-invalid @enderror">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            `;
            fotoContainer.appendChild(fotoRow);
        });
    });
</script> --}}