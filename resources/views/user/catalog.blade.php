@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2 class="fw-bold">Katalog Barang</h2>
    </div>
    
    @foreach($items as $item)
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            @if($item->image)
                <img src="{{ asset('storage/'.$item->image) }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
            @else
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">No Image</div>
            @endif
            <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold">{{ $item->name }}</h5>
                <p class="card-text text-muted mb-2">{{ $item->category->name ?? '-' }}</p>
                <p class="card-text fw-bold text-primary fs-5 mb-2">Rp. {{ number_format($item->price, 0, ',', '.') }}</p>
                <p class="card-text mb-3">Stok: {{ $item->quantity }}</p>
                
                <div class="mt-auto">
                    @if($item->quantity > 0)
                        <form action="{{ route('cart.add', $item->id) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $item->quantity }}" class="form-control w-25">
                            <button type="submit" class="btn btn-primary w-75 fw-bold">Tambah ke Keranjang</button>
                        </form>
                    @else
                        <button class="btn btn-secondary w-100 fw-bold" disabled>Barang sudah habis...</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
