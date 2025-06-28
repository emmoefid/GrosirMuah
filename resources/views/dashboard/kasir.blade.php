@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard Kasir</h2>

    <div class="alert alert-info">
        Total Transaksi yang kamu proses: <strong>{{ $totalTransaksi }}</strong>
    </div>

    <a href="{{ route('sales.create') }}" class="btn btn-primary">Mulai Transaksi</a>

    <hr>
    <h4>Transaksi Terakhir</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Dibayar</th>
                <th>Kembalian</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recentSales as $sale)
                <tr>
                    <td>{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                    <td>Rp{{ number_format($sale->total_price, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($sale->paid_amount, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($sale->change, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Belum ada transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection