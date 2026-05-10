@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body p-5" id="printableArea">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">FAKTUR PENJUALAN</h2>
                    <h5 class="text-muted">{{ $invoice->invoice_number }}</h5>
                </div>
                
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="mb-3 fw-bold">Dari:</h6>
                        <div><strong>PT Londo Bell</strong></div>
                        <div>Jalan Kebon Kacang Raya</div>
                        <div>Jakarta Pusat, 10240</div>
                    </div>
                    <div class="col-sm-6 text-sm-end">
                        <h6 class="mb-3 fw-bold">Kepada:</h6>
                        <div><strong>{{ $invoice->user->name }}</strong></div>
                        <div>{{ $invoice->shipping_address }}</div>
                        <div>Kode Pos: {{ $invoice->postal_code }}</div>
                    </div>
                </div>

                <div class="table-responsive-sm mb-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Kategori</th>
                                <th>Item</th>
                                <th class="right">Harga</th>
                                <th class="center">Qty</th>
                                <th class="right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->invoiceItems as $index => $item)
                            <tr>
                                <td class="center">{{ $index + 1 }}</td>
                                <td class="left">{{ $item->item->category->name ?? '-' }}</td>
                                <td class="left">{{ $item->item->name ?? '-' }}</td>
                                <td class="right">Rp. {{ number_format($item->item->price ?? 0, 0, ',', '.') }}</td>
                                <td class="center">{{ $item->quantity }}</td>
                                <td class="right fw-bold">Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5 ms-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left fw-bold fs-5"><strong>Total Harga</strong></td>
                                    <td class="right fw-bold fs-5 text-primary text-end"><strong>Rp. {{ number_format($invoice->total_price, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white p-3 text-end">
                <button class="btn btn-primary fw-bold" onclick="window.print()">Cetak Faktur</button>
            </div>
        </div>
    </div>
</div>
@endsection
