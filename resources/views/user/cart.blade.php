@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h4 class="mb-0 fw-bold">Keranjang Belanja</h4>
            </div>
            <div class="card-body">
                @if(empty($cart))
                    <p class="text-center my-5 text-muted">Keranjang kosong</p>
                @else
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cart as $id => $details)
                            @php 
                                $subtotal = $details['price'] * $details['quantity'];
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($details['image'])
                                            <img src="{{ asset('storage/'.$details['image']) }}" alt="{{ $details['name'] }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $details['name'] }}</div>
                                            <div class="text-muted small">{{ $details['category'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp. {{ number_format($details['price'], 0, ',', '.') }}</td>
                                <td>{{ $details['quantity'] }}</td>
                                <td class="fw-bold">Rp. {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total Harga:</td>
                                <td class="fw-bold text-primary fs-5">Rp. {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0 fw-bold">Checkout</h4>
            </div>
            <div class="card-body">
                @if(!empty($cart))
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Alamat Pengiriman</label>
                        <textarea name="shipping_address" required minlength="10" maxlength="100" class="form-control" rows="3">{{ old('shipping_address') }}</textarea>
                        @error('shipping_address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Kode Pos</label>
                        <input type="text" name="postal_code" required pattern="[0-9]{5}" title="Harus 5 digit angka" class="form-control" value="{{ old('postal_code') }}">
                        @error('postal_code') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold fs-5">Proses Checkout</button>
                </form>
                @else
                <button class="btn btn-secondary w-100 fw-bold" disabled>Keranjang Kosong</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
