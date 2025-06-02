<x-backend.layoutDash>
    <div class="container">
        <h4>Add Modifier for: {{ $product->product_name }}</h4>
    
        <form action="{{ route('backend.product.add_modifier.store', $product->product_id) }}" method="POST">
            @csrf
    
            <div class="mb-3">
                <label for="category_id" class="form-label">Modifier Category</label>
                <select id="category_id" name="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="mb-3 d-none" id="modifier-dropdown">
                <label for="mod_id" class="form-label">Modifier</label>
                <select id="mod_id" name="mod_id" class="form-select" required>
                    <option value="">Select Modifier</option>
                </select>
            </div>
    
            <div class="mb-3 d-none" id="modifier-price">
                <label for="mod_price" class="form-label">Price</label>
                <input type="number" step="any" min="0" class="form-control" id="mod_price" name="mod_price" required>
            </div>
    
            <button type="submit" class="btn btn-primary">Add Modifier</button>
        </form>
    </div>
    
    <script>
    document.getElementById('category_id').addEventListener('change', function() {
        let categoryId = this.value;
        let modifierDropdown = document.getElementById('modifier-dropdown');
        let modifierSelect = document.getElementById('mod_id');
        let priceDiv = document.getElementById('modifier-price');
        modifierDropdown.classList.add('d-none');
        priceDiv.classList.add('d-none');
        modifierSelect.innerHTML = '<option value="">Select Modifier</option>';
        if(categoryId) {
            fetch('{{ route('backend.product.modifiers_by_category') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({category_id: categoryId})
            })
            .then(res => res.json())
            .then(data => {
                if(data.length > 0) {
                    data.forEach(function(mod) {
                        let option = document.createElement('option');
                        option.value = mod.mod_id;
                        option.text = mod.mod_name;
                        modifierSelect.appendChild(option);
                    });
                    modifierDropdown.classList.remove('d-none');
                }
            });
        }
    });
    
    document.getElementById('mod_id').addEventListener('change', function() {
        let priceDiv = document.getElementById('modifier-price');
        if(this.value) {
            priceDiv.classList.remove('d-none');
        } else {
            priceDiv.classList.add('d-none');
        }
    });
    </script>
</x-backend.layoutDash>