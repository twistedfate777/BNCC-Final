@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0 fw-bold">Edit Barang</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.items.update', $item) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Kategori Barang</label>
                        <select name="category_id" required class="form-select">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="name" value="{{ old('name', $item->name) }}" required minlength="5" maxlength="80" class="form-control">
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Barang (Rp.)</label>
                        <input type="number" name="price" value="{{ old('price', $item->price) }}" required min="0" class="form-control">
                        @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Barang</label>
                        <input type="number" name="quantity" value="{{ old('quantity', $item->quantity) }}" required min="0" class="form-control">
                        @error('quantity') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Foto Barang (Kosongkan jika tidak diubah)</label>
                        <input type="file" name="image" accept="image/*" class="form-control">
                        @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary fw-bold">Update</button>
                        <a href="{{ route('admin.items.index') }}" class="btn btn-secondary fw-bold">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
