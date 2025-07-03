@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px;">
    <h4>Detail Transaksi</h4>
    <p><strong>Waktu:</strong> {{ $sale->created_at->format('d-m-Y H:i') }}</p>
    <p><strong>Kasir:</strong> {{ $sale->user->name }}</p>

    <table class="table table-sm">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp{{ number_format($item->price_per_unit, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total:</strong> Rp{{ number_format($sale->total_price, 0, ',', '.') }}</p>
    <p><strong>Bayar:</strong> Rp{{ number_format($sale->paid_amount, 0, ',', '.') }}</p>
    <p><strong>Kembalian:</strong> Rp{{ number_format($sale->change, 0, ',', '.') }}</p>
</div>
@endsection