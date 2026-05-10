@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <h4 class="mb-0 fw-bold">Data Barang</h4>
        <a href="{{ route('admin.items.create') }}" class="btn btn-primary fw-bold">Tambah Barang</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Foto Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori Barang</th>
                    <th>Harga Barang</th>
                    <th>Jumlah Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>
                        @if($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                        @endif
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus barang ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
