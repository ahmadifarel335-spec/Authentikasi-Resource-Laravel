@php($isEditing = $product !== null)

@if ($categories->isEmpty())
    <div class="alert alert-warning" role="alert">
        Belum ada kategori. Jalankan seeder kategori sebelum menambahkan produk.
    </div>
@endif

<form method="POST" action="{{ $isEditing ? route('admin.produk.update', $product) : route('admin.produk.store') }}">
    @csrf
    @if ($isEditing)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label for="name" class="form-label">Nama produk</label>
        <input id="name" name="name" type="text" value="{{ old('name', $product?->name) }}" class="form-control @error('name') is-invalid @enderror" maxlength="255" required autofocus>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="sku" class="form-label">SKU</label>
        <input id="sku" name="sku" type="text" value="{{ old('sku', $product?->sku) }}" class="form-control @error('sku') is-invalid @enderror" maxlength="255" required>
        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Kategori</label>
        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
            <option value="">Pilih kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $product?->category_id) === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="row">
        <div class="col-sm-6 mb-3">
            <label for="price" class="form-label">Harga (Rp)</label>
            <input id="price" name="price" type="number" min="0" step="1" value="{{ old('price', $product?->price) }}" class="form-control @error('price') is-invalid @enderror" required>
            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-sm-6 mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input id="stock" name="stock" type="number" min="0" step="1" value="{{ old('stock', $product?->stock) }}" class="form-control @error('stock') is-invalid @enderror" required>
            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>
    <div class="d-flex gap-2 pt-2">
        <button type="submit" class="btn btn-primary" @disabled($categories->isEmpty())>{{ $isEditing ? 'Simpan perubahan' : 'Simpan produk' }}</button>
        <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
