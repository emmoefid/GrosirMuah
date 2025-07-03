@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Transaksi</h2>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->created_at->format('d-m-Y H:i') }}</td>
                <td>{{ $sale->user->name }}</td>
                <td>Rp{{ number_format($sale->total_price, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('sales.history.detail', $sale->id) }}" class="btn btn-sm btn-info">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection